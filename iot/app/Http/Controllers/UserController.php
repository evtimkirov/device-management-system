<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Create a new user
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        User::create($request->only('name', 'email', 'password'));

        return response()->json([
            'status' => 'success',
            'message' => 'The user has been created successfully.',
        ]);
    }

    /**
     * Delete user
     *
     * @param DeleteUserRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteUserRequest $request): JsonResponse
    {
        User::findOrFail($request->id)->delete();

        return response()->json(['message' => 'The user has been deleted successfully.']);
    }
}
