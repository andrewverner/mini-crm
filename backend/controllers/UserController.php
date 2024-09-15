<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\controllers\actions\user\AssignRoleAction;
use backend\controllers\actions\user\BlockAction;
use backend\controllers\actions\user\DeleteAction;
use backend\controllers\actions\user\IndexAction;
use backend\controllers\actions\user\UpdateAction;
use backend\controllers\actions\user\ViewAction;
use yii\base\Action;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

final class UserController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['GET'],
                    'assign-role' => ['POST', 'AJAX'],
                    'update' => ['GET', 'POST'],
                    'view' => ['GET'],
                    'delete' => ['POST'],
                    'block' => ['GET'],
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
            'assign-role' => AssignRoleAction::class,
            'update' => UpdateAction::class,
            'view' => ViewAction::class,
            'delete' => DeleteAction::class,
            'block' => BlockAction::class,
        ];
    }
}
