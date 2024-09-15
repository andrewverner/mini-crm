<?php

declare(strict_types=1);

namespace common\strategies\email;

use common\models\Token;
use Yii;

final readonly class ActivationTokenEmailJobStrategy implements EmailJobStrategyInterface
{
    public function __construct(
        private Token $token,
    ) {
    }

    public function getHtmlBody(): string
    {
        return Yii::$app->controller->renderFile(
            file: Yii::getAlias(alias: '@common/mail') . '/activation.php',
            params: [
                'subject' => $this->getSubject(),
                'token' => $this->token,
            ]);
    }

    public function getSubject(): string
    {
        return 'Activate your account';
    }
}
