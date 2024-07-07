<?php

namespace app\controllers;

use app\filtro\JwtAuth;
use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\Response;

class UserController extends Controller
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
        $model = new User();
        $model->load(Yii::$app->request->post(), '');
        
        if ($model->save()) {
            return ['status' => 'success', 'data' => $model];
        } 
        Yii::debug('Erro ao criar usuário: ' . print_r($model->errors, true));
        return ['status' => 'error', 'errors' => $model->errors];
    }
}
