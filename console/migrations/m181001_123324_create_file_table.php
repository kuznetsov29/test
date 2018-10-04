<?php

use yii\db\Migration;

/**
 * Handles the creation of table `file`.
 *
 * Class m180823_143813_create_file_table
 * @author Pavel Kuznetsov <kuznetsov-web@bk.ru>
 */
class m181001_123324_create_file_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('file', [
            'id' => $this->primaryKey(),
            'path' => $this->string(255)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(5),
            'extension' => $this->string(255)->notNull(),
            'base_name' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('file');
    }
}
