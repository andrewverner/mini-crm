<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\controllers\actions\ticket\DownloadAction;
use backend\controllers\actions\ticket\IndexAction;
use backend\controllers\actions\ticket\UpdateAction;
use backend\controllers\actions\ticket\ViewAction;
use yii\base\Action;
use yii\filters\AccessControl;
use yii\web\Controller;

final class TicketController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'manager'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return array<array-key, Action>
     */
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
            'view' => ViewAction::class,
            'update' => UpdateAction::class,
            'download' => DownloadAction::class,
        ];
    }
}
