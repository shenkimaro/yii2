<?php

namespace app\models;

use app\utilitario\Conversor;
use app\utilitario\Validador;
use yii\db\ActiveRecord;

class Cliente extends ActiveRecord
{
    public $fotoFile;

    public function rules()
    {
        return [
            [['nome', 'sexo', 'cpf'], 'required'],
            [['nome', 'cep', 'logradouro', 'numero', 'cidade', 'estado', 'complemento', 'sexo'], 'string'],
            ['cpf', 'validaCPF'],
            ['sexo', 'validaSexo'],
            [['fotoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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
                $filePath = '/var/www/uploads/' . $nome_arquivo . '.' . $this->fotoFile->extension;
                $this->fotoFile->saveAs($filePath,false);
                $this->foto = $filePath;
            }
            return true;
        } 
        return false;
    }
}
