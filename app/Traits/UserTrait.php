<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait UserTrait
{
    private const ERROR_ADMIN_ONLY = 'Solo los administradores pueden realizar esta acción';
    private const ERROR_USER_NOT_FOUND = 'Usuario no encontrado';
    private const ERROR_VALIDATION = 'Error en la validación de los datos';

    /**
     * Verifica si el usuario actual es administrador
     */
    protected function checkAdminPermission(): ?JsonResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => self::ERROR_ADMIN_ONLY], 403);
        }
        return null;
    }

    /**
     * Reglas de validación comunes para usuario
     */
    protected function getUserValidationRules(bool $isRequired = true): array
    {
        $rules = [
            'name' => 'max:191',
            'email' => 'email|unique:users|max:191',
            'password' => 'max:191',
        ];

        if ($isRequired) {
            $rules = array_map(function($rule) {
                return 'required|' . $rule;
            }, $rules);
        }

        return $rules;
    }

    /**
     * Genera una respuesta de error de validación
     */
    protected function validationErrorResponse($errors): JsonResponse
    {
        return response()->json([
            'message' => self::ERROR_VALIDATION,
            'errors' => $errors,
            'status' => 400
        ], 400);
    }

    /**
     * Genera una respuesta de usuario no encontrado
     */
    protected function userNotFoundResponse(): JsonResponse
    {
        return response()->json([
            'message' => self::ERROR_USER_NOT_FOUND,
            'status' => 404
        ], 404);
    }
}
