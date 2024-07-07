<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\Cliente;
use app\filtro\JwtAuth;
use app\models\Produto;
use yii\data\ActiveDataProvider;

class ProdutoController extends Controller
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
        $model = new Produto();
        $model->load(Yii::$app->request->post(), '');
        $model->fotoFile = UploadedFile::getInstanceByName('foto');

        if ($model->uploadFoto() && $model->save(false)) {
            return ['status' => 'success', 'data' => $model];
        } 
        Yii::debug('Erro ao criar o produto: ' . print_r($model->errors, true));
        return ['status' => 'error', 'errors' => $model->errors];
    }

    public function actionIndex()
    {
        $query = Produto::find()->alias('p');
        $query->innerJoin('cliente c', 'p.fk_cliente = c.id');

        $requestParams = Yii::$app->request->queryParams;

        if (!empty($requestParams['nome_cliente'])) {
            $query->andWhere(['like', 'c.nome', $requestParams['nome_cliente']]);
        }

        if (!empty($requestParams['cpf'])) {
            $query->andWhere(['c.cpf' => $requestParams['cpf']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }
}
