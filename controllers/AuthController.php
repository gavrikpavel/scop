<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Class AuthController
 * @package app\controllers
 */
class AuthController extends Controller
{
    /**
     * Определение фильтров контроля доступа
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'login'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['operator','engineer', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['login'],
                        'roles' => ['guest'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}