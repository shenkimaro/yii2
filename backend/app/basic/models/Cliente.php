<?php

namespace app\models;

use app\utilitario\Conversor;
use app\utilitario\Validador;
use yii\db\ActiveRecord;

class Cliente extends ActiveRecord
{
    public $fotoFile;

	const uploadPath = '/var/www/uploads/';

    public function rules()
    {
        return [
            [['nome', 'sexo', 'cpf'], 'required'],
            [['nome', 'cep', 'logradouro', 'numero', 'cidade', 'estado', 'complemento', 'sexo'], 'string'],
            ['cpf', 'validaCPF'],
            ['sexo', 'validaSexo'],
            [['foto'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    public function validaCPF($attribute, $params, $validator)
    {
        $cpf = $this->$attribute;
        
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        if(!Validador::ehCpf($cpf)){
            $this->addError($attribute, 'O CPF é inválido.');
            return false;
        }
    }

    public function validaSexo($attribute, $params, $validator)
    {
        $sexo = $this->$attribute;
        
        switch (trim($sexo)) {
            case 'M':
            case 'F':
            case 'I':    
                break;
            
            default:
                $this->addError($attribute, 'O campo sexo deve conter apenas os valores (M - Masculino, F - Feminino e I - não informado).');
                return;
        }
    }

    public function uploadFoto()
    {
        if ($this->validate()) {
            if ($this->fotoFile) {
                //tratando nome do arquivo de modo a remover caracteres estranhos
                $nome_arquivo = base64_encode(Conversor::somenteAlfaNumerico($this->fotoFile->baseName).$this->cpf);
                $filePath = self::uploadPath . $nome_arquivo . '.' . $this->fotoFile->extension;
                $this->fotoFile->saveAs($filePath,false);
                $this->foto = $filePath;
            }
            return true;
        } 
        return false;
    }

	public function afterFind()
    {
        parent::afterFind();
        $this->foto= str_replace('/var/www/uploads/', 'http://localhost:9999/foto/view/', $this->foto);
    }

    public static function findCliente($id)
    {
        return static::findOne($id);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->cpf = Conversor::somenteNumero($this->cpf);
            return true;
        }
        return false;
    }
}
