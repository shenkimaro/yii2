<?php

namespace app\controllers;

use app\filtro\JwtAuth;
use Yii;
use yii\rest\Controller;
use yii\web\Response;
use app\models\User;
use app\utilitario\UtilLbr;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends Controller
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
        return $behaviors;
    }

    public function actionLogin()
    {
        $request = Yii::$app->request;
        $username = $request->post('login');
        $password = $request->post('senha');
        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {
            $id = base64_encode($user->id + (new JwtAuth())->salt);
            $token = JWT::encode(['id' => $id, 'exp' => time() + 3600], Yii::$app->params['jwtSecretKey'], 'HS256');
            return ['token' => $token];
        } 
        return ['error' => 'Usuário ou senha invalídos'];
    }

    public function actionValidateToken()
    {
        $request = Yii::$app->request;
        $token = $request->post('token');

        try {
            $decoded = JWT::decode($token, new Key(Yii::$app->params['jwtSecretKey'], 'HS256'));
            return ['status' => 'success', 'data' => $decoded];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Invalid token'];
        }
    }
}
