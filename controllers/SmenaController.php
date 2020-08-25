<?php

namespace app\controllers;

use app\models\Record;
use app\models\Smena;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

/**
 * Class AuthController
 * @package app\controllers
 */
class SmenaController extends Controller
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
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['operator', 'engineer', 'admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->findContinueSmena()) {
            $model = new Smena();
        }
        else {
            $model = $this->findContinueSmena();
            $model->usersInSmena = $model->users;
        }

        return $this->render('index', [
            'model' => $model,
            'usersName' => User::shortNameUsers(),
            'smenaEvents' => Json::encode($model->getSmenaEvents()),
        ]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionTakeSmena()
    {
        if (Yii::$app->user->can('takeSmena')) {
            if (!$this->findContinueSmena()) { // Принимать смену только если завершена предыдущая смена
                $model = new Smena();
                $record = new Record();
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    $model->takeSmena();
                    $record->saveRecordSmena(
                        $model->setText('принял(и)'),
                        $model->comment
                    );
                }
                $model->usersInSmena = $model->users;
                return $this->render('index', [
                    'model' => $model,
                    'usersName' => User::shortNameUsers(),
                    'smenaEvents' => Json::encode($model->getSmenaEvents()),
                ]);
            }
            return $this->render('smena_error', ['message' => 'Необходимо сдать текущую смену']);
        }
        throw new ForbiddenHttpException('Вы не можете принять смену!');
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     */
    public function actionGiveSmena()
    {
        if (Yii::$app->user->can('giveSmena')) {
            $model = $this->findContinueSmena();
            if ($model) {
                if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                    if ($model && $model->checkOutSmena()) { // Сдавать смену, если не завершена текущая смена и в смене есть пользователь авторизованный в системе
                        $record = new Record();
                        $record->saveRecordSmena(
                            $model->setText('сдал(и)'),
                            $model->comment
                        );
                        $model->giveSmena();
                        Yii::$app->user->logout();
                        return $this->goHome();
                    }
                }
                return $this->render('smena_error', ['message' => 'Только персонал зарегистрированный в смене может сдать текущую смену']);
            }
        }
        throw new ForbiddenHttpException('Вы не можете сдать смену!');
    }

    /**
     * @return Smena|array|bool|\yii\db\ActiveRecord
     */
    protected function findContinueSmena()
    {
        if (($model = Smena::find()->orderBy('id DESC')->where(['is_end' => false])->one()) !== null) {
            return $model;
        }
        return false;
    }
}