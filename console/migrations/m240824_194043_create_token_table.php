<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%token}}`.
 */
final class m240824_194043_create_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(
            table: '{{%token}}',
            columns: [
                'id' => $this->primaryKey(),
                'user_id' => $this->string(length: 36)->notNull(),
                'value' => $this->string(length: 255)->notNull(),
                'type' => $this->tinyInteger()->notNull()->defaultValue(default: 1),
                'created_at' => $this->dateTime()->notNull(),
                'expired_at' => $this->dateTime()->notNull(),
                'used_at' => $this->dateTime()->null(),
            ],
            options: 'charset=utf8',
        );
        $this->createIndex(name: 'idx_token_value', table: '{{%token}}', columns: 'value');
        $this->addForeignKey(
            name: 'token_user_id_fk', table: '{{%token}}', columns: 'user_id', refTable: '{{%user}}', refColumns: 'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(name: 'token_user_id_fk', table: '{{%token}}');
        $this->dropIndex(name: 'idx_token_value', table: '{{%token}}');
        $this->dropTable(table: '{{%token}}');
    }
}
