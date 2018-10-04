<?php

use yii\db\Migration;

/**
 * Handles the creation of table `post`.
 * Has foreign keys to the tables:
 *
 * - `file`
 */
class m181001_123454_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(511),
            'content' => $this->text(),
            'image_id' => $this->integer(),
        ]);

        // creates index for column `image_id`
        $this->createIndex(
            'idx-post-image_id',
            'post',
            'image_id'
        );

        // add foreign key for table `file`
        $this->addForeignKey(
            'fk-post-image_id',
            'post',
            'image_id',
            'file',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `file`
        $this->dropForeignKey(
            'fk-post-image_id',
            'post'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-post-image_id',
            'post'
        );

        $this->dropTable('post');
    }
}
