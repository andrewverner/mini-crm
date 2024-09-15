<?php

namespace frontend\controllers;

use frontend\controllers\actions\site\IndexAction;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actions(): array
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}
