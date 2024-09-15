<?php

declare(strict_types=1);

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ticket_changelog}}`.
 */
class m240915_180951_create_ticket_changelog_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(
            table: '{{%ticket_changelog}}',
            columns: [
                'id' => $this->primaryKey(),
                'ticket_id' => $this->integer()->notNull(),
                'user_id' => $this->string(length: 36)->notNull(),
                'data' => $this->text()->notNull(),
                'created_at' => $this->dateTime()->notNull(),
            ],
            options: 'charset=utf8',
        );
        $this->addForeignKey(
            name: 'fk_ticket_changelog_ticket_id',
            table: '{{%ticket_changelog}}',
            columns: 'ticket_id',
            refTable: '{{%ticket}}',
            refColumns: 'id',
        );
        $this->addForeignKey(
            name: 'fk_ticket_changelog_user_id',
            table: '{{%ticket_changelog}}',
            columns: 'user_id',
            refTable: '{{%user}}',
            refColumns: 'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey(name: 'fk_ticket_changelog_user_id', table: '{{%ticket_changelog}}');
        $this->dropForeignKey(name: 'fk_ticket_changelog_ticket_id', table: '{{%ticket_changelog}}');
        $this->dropTable(table: '{{%ticket_changelog}}');
    }
}
