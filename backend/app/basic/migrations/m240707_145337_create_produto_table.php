<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produto}}`.
 */
class m240707_145337_create_produto_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%produto}}', [
            'id' => $this->primaryKey(),
            'nome' => $this->string()->notNull(),
            'preco' => $this->float()->notNull(),
            'fk_cliente' => $this->integer()->notNull(),
            'foto' => $this->string(),
        ]);

        $this->createIndex(
            '{{%idx-produto-fk_cliente}}',
            '{{%produto}}',
            'fk_cliente'
        );

        $this->addForeignKey(
            '{{%fk-produto-fk_cliente}}',
            '{{%produto}}',
            'fk_cliente',
            '{{%cliente}}',
            'id',
            'CASCADE'
        );
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%produto}}');
    }
}
