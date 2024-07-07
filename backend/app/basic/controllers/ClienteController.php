<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\Cliente;
use app\filtro\JwtAuth;
use yii\data\ActiveDataProvider;

class ClienteController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['authenticator'] = [
            'class' => JwtAuth::class,
        ];
        return $behaviors;
    }

    public function actionCreate()
    {
        $model = new Cliente();
        $model->load(Yii::$app->request->post(), '');
        $model->fotoFile = UploadedFile::getInstanceByName('foto');

        if ($model->uploadFoto() && $model->save(false)) {
            return ['status' => 'success', 'data' => $model];
        } 
        Yii::debug('Erro ao criar cliente: ' . print_r($model->errors, true));
        return ['status' => 'error', 'errors' => $model->errors];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Cliente::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }
}
