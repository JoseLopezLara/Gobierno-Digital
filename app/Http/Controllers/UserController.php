<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use UserTrait;

    /**
     * Muestra listado de todos los usuarios
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
            'status' => 200
        ]);
    }

    /**
     * Crea un nuevo usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($adminCheck = $this->checkAdminPermission()) {
            return $adminCheck;
        }

        $validator = Validator::make($request->all(), $this->getUserValidationRules());

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Crear usuario y asignar rol
        $user = User::create($request->only(['name', 'email', 'password']));
        $userRole = Role::where('slug', 'user')->first();
        $user->roles()->attach($userRole->id);

        return response()->json([
            'message' => 'Usuario creado exitosamente',
            'user' => $user,
            'status' => 201
        ], 201);
    }

    /**
     * Muestra un usuario específico
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->userNotFoundResponse();
        }

        return response()->json([
            'user' => $user,
            'status' => 200
        ]);
    }

    /**
     * Actualiza un usuario
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if ($adminCheck = $this->checkAdminPermission()) {
            return $adminCheck;
        }

        $user = User::find($id);

        if (!$user) {
            return $this->userNotFoundResponse();
        }

        $validator = Validator::make($request->all(), $this->getUserValidationRules());

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        $user->fill($request->only(['name', 'email', 'password']));
        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user,
            'status' => 200
        ]);
    }

    /**
     * Actualiza parcialmente un usuario
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePartial(Request $request, $id)
    {
        if ($adminCheck = $this->checkAdminPermission()) {
            return $adminCheck;
        }

        $user = User::find($id);

        if (!$user) {
            return $this->userNotFoundResponse();
        }

        $validator = Validator::make($request->all(), $this->getUserValidationRules(false));

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator->errors());
        }

        // Actualizar solo los campos proporcionados
        $user->fill($request->only(['name', 'email', 'password']));
        $user->save();

        return response()->json([
            'message' => 'Usuario actualizado exitosamente',
            'user' => $user,
            'status' => 200
        ]);
    }

    /**
     * Elimina un usuario
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        if ($adminCheck = $this->checkAdminPermission()) {
            return $adminCheck;
        }

        $user = User::find($id);

        if (!$user) {
            return $this->userNotFoundResponse();
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente',
            'status' => 200
        ]);
    }
}
