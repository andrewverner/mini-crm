<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
final class m240824_193314_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(
            table: '{{%user}}',
                columns: [
                'id' => $this->string(length: 36)->notNull(),
                'email' => $this->string()->notNull()->unique(),
                'password' => $this->string()->notNull(),
                'active' => $this->boolean()->notNull()->defaultValue(default: 0),
                'blocked' => $this->boolean()->notNull()->defaultValue(default: 0),
                'created_at' => $this->dateTime()->notNull(),
                'deleted_at' => $this->dateTime()->null(),
            ],
            options: 'charset=utf8',
        );
        $this->addPrimaryKey(name: 'user_pk', table: '{{%user}}', columns: 'id');
        $this->createIndex(name: 'idx_user_email', table: '{{%user}}', columns: 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropIndex(name: 'idx_user_email', table: '{{%user}}');
        $this->dropPrimaryKey(name: 'user_pk', table: '{{%user}}');
        $this->dropTable(table: '{{%user}}');
    }
}
