<?php

namespace backend\controllers;

use backend\controllers\actions\site\ActivateAction;
use backend\controllers\actions\site\ForgetPasswordAction;
use backend\controllers\actions\site\LoginAction;
use backend\controllers\actions\site\ResetPasswordAction;
use backend\controllers\actions\site\SignUpAction;
use Yii;
use yii\base\Action;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

/**
 * Site controller
 */
final class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'sign-up', 'activate', 'forget-password', 'reset-password', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                    'sign-up' => ['GET', 'POST'],
                    'login' => ['GET', 'POST'],
                    'activate' => ['GET'],
                    'forget-password' => ['GET', 'POST'],
                    'reset-password' => ['GET', 'POST'],
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
            'error' => ErrorAction::class,
            'sign-up' => SignUpAction::class,
            'login' => LoginAction::class,
            'activate' => ActivateAction::class,
            'forget-password' => ForgetPasswordAction::class,
            'reset-password' => ResetPasswordAction::class,
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render(view: 'index');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
