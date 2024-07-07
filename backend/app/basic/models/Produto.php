<?php

namespace app\models;

use app\utilitario\Conversor;
use app\utilitario\Validador;
use yii\db\ActiveRecord;

class Produto extends ActiveRecord
{
    public $fotoFile;

    public function rules()
    {
        return [
            [['nome', 'preco', 'fk_cliente'], 'required'],
            ['fk_cliente', 'validaCliente'],
            [['foto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function validaCliente($attribute, $params, $validator)
    {
        $idCliente = $this->$attribute;

        $cliente = new Cliente();

        $clienteDataBase = $cliente->findCliente($idCliente);
        
        if( $clienteDataBase == null){
            $this->addError($attribute, 'O Cliente informado não foi encontrado.');
            return false;
        }
    }    

    public function uploadFoto()
    {
        if ($this->validate()) {
            if ($this->fotoFile) {
                //tratando nome do arquivo de modo a remover caracteres estranhos
                $nome_arquivo = base64_encode(Conversor::somenteAlfaNumerico($this->fotoFile->baseName).rand(10,99));
                $filePath = '/var/www/uploads/' . $nome_arquivo . '.' . $this->fotoFile->extension;
                $this->fotoFile->saveAs($filePath,false);
                $this->foto = $filePath;
            }
            return true;
        } 
        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->preco = Conversor::moedaDb($this->preco);
            return true;
        }
        return false;
    }
}
