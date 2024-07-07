<?php

namespace app\filtro;

use Yii;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use app\models\User;

class JwtAuth extends ActionFilter
{
    public $salt = 450;

    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;
        $authHeader = $headers->get('Authorization');
        if (!($authHeader && preg_match('/^Bearer\s+(.*)$/', $authHeader, $matches))) {
            throw new ForbiddenHttpException('Nenhum token informado');
        }
        $token = $matches[1];
        try {
            $decoded = JWT::decode($token, new Key(Yii::$app->params['jwtSecretKey'], 'HS256'));
            $id = base64_decode($decoded->id) - $this->salt;
            Yii::$app->user->login(User::findIdentity($id));
            return parent::beforeAction($action);
        } catch (\Exception $e) {
            throw new ForbiddenHttpException('Token invalido');
        }
    }
}
