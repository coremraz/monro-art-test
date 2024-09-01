<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetCodeRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\SettingConfirmationService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;

    private SettingConfirmationService $settingService;

    public function __construct(SettingConfirmationService $settingService)
    {
        $this->settingService = $settingService;
    }

    //Можно получить всех пользователей и общее количество
    public function index()
    {
        $users = User::all();
        $userCount = User::count();

        return $this->successResponse(compact('users', 'userCount'));
    }

    public function show($id)
    {
        return $this->successResponse(User::where('id', $id)->get());
    }

    //Непосредственно обновление юзера

    public function update(UpdateUserRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::find($request->id);

        if (!$user) {
            return $this->errorResponse('User not found', 404);
        }

        $user->update($validatedData);

        return $this->successResponse(null, 'success');
    }

    //Запрос кода
    public function requestConfirmationCode(GetCodeRequest $request)
    {
        $code = $this->settingService->generateConfirmationCode($request->id, $request->channel);

        return $this->successResponse(["code" => $code]);
    }

    //проверка кода
    public function checkConfirmationCode(Request $request)
    {
        if ($this->settingService->checkConfirmationCode($request->id, $request->code)) {
            return $this->successResponse(null, true);
        } else {
            return $this->errorResponse(null, 403);
        }
    }
}
