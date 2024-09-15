<?php

declare(strict_types=1);

namespace common\models;

use common\enums\UserStatusEnum;
use common\events\UserEventsListener;
use Faker\Provider\Uuid;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property int $active
 * @property int $blocked
 * @property string $created_at
 * @property string|null $deleted_at
 *
 * @property Token[] $tokens
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const array STATUS_MAP = [
        UserStatusEnum::ACTIVE->value => 'active',
        UserStatusEnum::INACTIVE->value => 'inactive',
        UserStatusEnum::BLOCKED->value => 'blocked',
        UserStatusEnum::DELETED->value => 'deleted',
    ];

    public function init(): void
    {
        $this->on(name: self::EVENT_AFTER_INSERT, handler: [UserEventsListener::class, 'createActivationToken']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'email', 'password', 'created_at'], 'required'],
            [['active', 'blocked'], 'integer'],
            [['created_at', 'deleted_at'], 'safe'],
            [['id'], 'string', 'max' => 36],
            [['email', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'password' => 'Password',
            'active' => 'Active',
            'blocked' => 'Blocked',
            'created_at' => 'Created At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Tokens]].
     *
     * @return ActiveQuery
     */
    public function getTokens(): ActiveQuery
    {
        return $this->hasMany(class: Token::class, link: ['user_id' => 'id']);
    }

    public static function findIdentity($id): User|IdentityInterface|null
    {
        return self::findOne(condition: $id);
    }

    public static function findIdentityByAccessToken($token, $type = null): null
    {
        return null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getAuthKey(): null
    {
        return null;
    }

    public function validateAuthKey($authKey): bool
    {
        return false;
    }

    public function beforeValidate(): bool
    {
        if ($this->isNewRecord) {
            $this->id = Uuid::uuid();
            $this->created_at = new Expression(expression: 'NOW()');
        }

        return parent::beforeValidate();
    }

    public function isValid(): bool
    {
        return $this->active === 1
            && $this->blocked === 0
            && $this->deleted_at === null;
    }

    public function getStatusCode(): int
    {
        return match (true) {
            $this->deleted_at !== null => UserStatusEnum::DELETED->value,
            $this->blocked === 1 => UserStatusEnum::BLOCKED->value,
            $this->active === 0 => UserStatusEnum::INACTIVE->value,
            default => UserStatusEnum::ACTIVE->value,
        };
    }
}
