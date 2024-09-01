<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class RegisteredUserController extends Controller
{
    use ApiResponseTrait;

    public function store(RegisterUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = new User($validatedData);
        $user->save();

        return $this->successResponse($user);
    }
}
