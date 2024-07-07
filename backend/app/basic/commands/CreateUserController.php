<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\User;

class CreateUserController extends Controller
{
    /**
     * Este comando cria um novo usuário.
     * 
     * @param string $login login do usuário
     * @param string $username o nome do usuário
     * @param string $password a senha do usuário
     * @return int Exit code
     */
    public function actionIndex($login, $username, $password)
    {
        $user = new User();
        $user->login = $login;
        $user->nome = $username;
        $user->senha = $password;

        if ($user->save()) {
            $this->stdout("Usuário criado com sucesso!\n");
            return ExitCode::OK;
        } 
        $this->stderr("Erro ao criar usuário:\n");
        foreach ($user->errors as $error) {
            $this->stderr("- " . implode("\n- ", $error) . "\n");
        }
        return ExitCode::UNSPECIFIED_ERROR;
    }
}
