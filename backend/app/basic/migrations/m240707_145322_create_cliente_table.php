<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cliente}}`.
 */
class m240707_145322_create_cliente_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cliente}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'cpf' => $this->string(11)->notNull(),
            'cep' => $this->string(8),
            'logradouro' => $this->string(),
            'numero' => $this->string(),
            'cidade' => $this->string(),
            'estado' => $this->string(2),
            'complemento' => $this->string(),
            'foto' => $this->string(),
            'sexo' => $this->string(1)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cliente}}');
    }
}
