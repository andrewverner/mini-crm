<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\controllers\actions\changelog\IndexAction;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

final class ChangelogController extends Controller
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
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
