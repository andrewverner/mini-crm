<?php

declare(strict_types=1);

namespace common\services;

use backend\models\LoginForm;
use backend\models\SignUpForm;

interface UserServiceInterface
{
    public function createUser(SignUpForm $signUpForm): bool;

    public function authenticateUser(LoginForm $loginForm): bool;

    public function assignRole(string $userId, string $roleName): void;

    public function delete(string $userId): void;

    public function block(string $userId): int;
}
