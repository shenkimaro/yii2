<?php

namespace app\controllers;

use app\models\Cliente;
use Yii;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FotoController extends Controller
{

    public $enableCsrfValidation = false;

    public function actionView()
    {
        $request = Yii::$app->request;
        $get = $request->get();
        $caminho = Cliente::uploadPath . $get['imagem']??'';
        if (!file_exists($caminho)) {
            throw new NotFoundHttpException("A imagem não foi encontrada.");
        }

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', mime_content_type($caminho));
        return file_get_contents($caminho);
    }
}
