<?php

namespace App\Services;

use App\Models\SettingConfirmationCode;
use Illuminate\Support\Str;

class SettingConfirmationService
{
    public function generateConfirmationCode(int $userId, string $channel): string
    {
        // Создаем код подтверждения
        $code = Str::random(6);
        SettingConfirmationCode::create([
            'user_id' => $userId,
            'code' => $code,
            'channel' => $channel,
            'expires_at' => now()->addMinutes(15) //через 15 мин код истечет
        ]);

        // Представим, что отправляем код подтверждения на выбранный канал :)
        $this->sendConfirmationCode($userId, $code, $channel);

        //Возвращаем код чисто для теста
        return $code;
    }

    public function checkConfirmationCode(int $userId, string $code): bool
    {
        $confirmationToken = SettingConfirmationCode::where('user_id', $userId)
            ->where('code', $code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$confirmationToken) {
            return false;
        } else {
            //Проверяем тождество введеного кода и кода в БД
            if ($code === $confirmationToken->code) {
                // Удаляем токен подтверждения
                $confirmationToken->delete();
                return true;
            } else {
                return false;
            }
        }
    }

    // Абстрактный метод отправки кода подтверждения
    private function sendConfirmationCode(int $userId, string $code, string $channel): bool
    {

        //если бы реально он был реализован, то в зависимости от канала выполнялся бы отдельный метод
        //Вероятно, я бы сделал отдельный сервис для этого, чтобы переиспользовать код
        return true;
    }
}
