<?php

declare(strict_types=1);

namespace backend\models;

use common\models\Ticket;
use common\models\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ticket_changelog".
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $user_id
 * @property string $data
 * @property string $created_at
 *
 * @property Ticket $ticket
 * @property User $user
 */
final class TicketChangelog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ticket_changelog}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['ticket_id', 'user_id', 'data', 'created_at'], 'required'],
            [['ticket_id'], 'integer'],
            [['data'], 'string'],
            [['created_at'], 'safe'],
            [['user_id'], 'string', 'max' => 36],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class, 'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'user_id' => 'User ID',
            'data' => 'Data',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return ActiveQuery
     */
    public function getTicket(): ActiveQuery
    {
        return $this->hasOne(class: Ticket::class, link: ['id' => 'ticket_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(class: User::class, link: ['id' => 'user_id']);
    }
}
