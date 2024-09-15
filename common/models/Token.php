<?php

declare(strict_types=1);

namespace common\models;

use common\enums\TokenCustomEventEnum;
use common\events\TokenEventsListener;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property string $value
 * @property string $user_id
 * @property int $type
 * @property string $created_at
 * @property string $expired_at
 * @property string|null $used_at
 *
 * @property User $user
 */
final class Token extends ActiveRecord
{
    public function init(): void
    {
        $this->on(name: self::EVENT_AFTER_INSERT, handler: [TokenEventsListener::class, 'sendEmailOnCreate']);
        $this->on(
            name: TokenCustomEventEnum::AFTER_USED_EVENT->value,
            handler: [TokenEventsListener::class, 'sendEmailOnUse']
        );
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['value', 'user_id', 'created_at', 'expired_at'], 'required'],
            [['type'], 'integer'],
            [['created_at', 'expired_at', 'used_at'], 'safe'],
            [['value', 'user_id'], 'string', 'max' => 36],
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
            'value' => 'Value',
            'user_id' => 'User ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'expired_at' => 'Expired At',
            'used_at' => 'Used At',
        ];
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

    public function afterSave($insert, $changedAttributes): void
    {
        if (
            array_key_exists(key: 'used_at', array: $changedAttributes)
            && $changedAttributes['used_at'] !== $this->used_at
        ) {
            $this->trigger(name: TokenCustomEventEnum::AFTER_USED_EVENT->value);
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
