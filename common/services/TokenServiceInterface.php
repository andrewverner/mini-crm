<?php

declare(strict_types=1);

namespace common\services;

use backend\models\ResetPasswordForm;
use common\models\User;

interface TokenServiceInterface
{
    public function createActivationToken(User $user): bool;

    public function createResetPasswordToken(User $user): bool;

    public function activateUser(string $hash): void;

    public function resetPassword(ResetPasswordForm $resetPasswordForm): bool;
}
