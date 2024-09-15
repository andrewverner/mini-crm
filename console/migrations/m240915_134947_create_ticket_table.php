<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket}}`.
 */
class m240915_134947_create_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(
            table: '{{%ticket}}',
            columns: [
                'id' => $this->primaryKey(),
                'status' => $this->tinyInteger()->notNull()->defaultValue(default: 1),
                'name' => $this->string()->notNull(),
                'phone' => $this->string(length: 11)->notNull(),
                'title' => $this->string()->notNull(),
                'comment' => $this->text()->notNull(),
                'item' => $this->string()->notNull(),
                'price' => $this->float()->null(),
                'created_at' => $this->dateTime()->notNull(),
            ],
            options: 'charset=utf8',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable(table: '{{%ticket}}');
    }
}
