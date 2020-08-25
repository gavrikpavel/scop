<?php

namespace app\controllers;

use app\models\ChangedRecord;
use app\models\Device;
use app\models\Plant;
use app\models\User;
use Yii;
use app\models\Record;
use app\models\RecordSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Class RecordController
 * @package app\controllers
 */
class RecordController extends Controller
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
                'only' => ['index', 'create', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['operator','engineer', 'admin'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update'],
                        'roles' => ['operator','admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'plants' => Plant::namePlants(),
            'users' => User::shortNameUsers(),
            'devices' => Device::kksDevices(),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $changedRecords = array_reverse($model->changedRecords);

        return $this->render('view', [
            'model' => $model,
            'changedRecords' => $changedRecords,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // Вставка имени устройства при выборе в Select2
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            return  $this->getTextDevice($data['id']);
        }

        $model = new Record();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $fed = $model;
//            if () {
//                $fed1 = $model;
//            }
            $model->saveFromJournal();
            return $this->redirect(['record/index']);
        }
        return $this->render('create', [
            'model' => $model,
            'plants' => Plant::namePlants(),
            'devices' => Device::kksDevices(),
            'currentUser' => Yii::$app->user->identity->short_name,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // Вставка имени устройства при выборе в Select2
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            return  $this->getTextDevice($data['id']);
        }

        $model = $this->findModel($id);
        $changedRecord = new ChangedRecord();
        $changedRecord->cloneRecord($model);

        if (Yii::$app->user->can('updateRecord', ['record' => $model])) {
            if ($model->load(Yii::$app->request->post())  && $model->validate()) {
                $model->updateFromJournal();
                $changedRecord->saveChangedRecord();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            return $this->render('update', [
                'model' => $model,
                'plants' => Plant::namePlants(),
                'devices' => Device::kksDevices(),
                'currentUser' => Yii::$app->user->identity->short_name,
            ]);
        }
        throw new ForbiddenHttpException('Данную запись не разрешено редактировать!');
    }

//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//        return $this->redirect(['index']);
//    }

    public function getTextDevice($id)
    {
        $device = Device::findOne($id);
        return   ' ' . $device->name . ' (' .  $device->kks . ') ';
    }

    /**
     * @param $id
     * @return Record|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Record::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемой страницы не существует.');
    }
}
