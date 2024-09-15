<?php

declare(strict_types=1);

namespace backend\models;

use common\models\User;
use common\repositories\UserRepositoryInterface;
use Yii;
use yii\base\Model;

final class LoginForm extends Model
{
    public ?string $email = null;
    public ?string $password = null;
    public ?bool $rememberMe = false;

    private ?User $user = null;

    public function rules(): array
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email']],
            ['password', 'string', 'min' => 6, 'max' => 12],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
            ['email', 'validateUser'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
            'rememberMe' => 'Remember me',
        ];
    }

    public function validateUser(): void
    {
        $user = $this->findUser();

        if ($user === null || !$user->isValid()) {
            $this->addError(
                attribute: 'email',
                error: 'Invalid email/password or account is inactive/blocked',
            );
        }
    }

    public function validatePassword(): void
    {
        $user = $this->findUser();

        if (
            $user === null
            || !Yii::$app->security->validatePassword($this->password, $user->password)
        ) {
            $this->addError(
                attribute: 'email',
                error: 'Invalid email/password or account is inactive/blocked',
            );
        }
    }

    public function getUser(): ?User
    {
        return $this->findUser();
    }

    private function findUser(): ?User
    {
        if ($this->user === null) {
            $userRepository = Yii::$container->get(class: UserRepositoryInterface::class);
            $this->user = $userRepository->findActiveUser(email: $this->email);
        }

        return $this->user;
    }
}
