<?php

declare(strict_types = 1);

namespace backend\models;

use common\models\User;
use common\repositories\UserRepositoryInterface;
use Yii;
use yii\base\Model;

class ForgetPasswordForm extends Model
{
    public ?string $email = null;

    private ?User $user = null;

    public function rules(): array
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'validateUser'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'Email',
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
