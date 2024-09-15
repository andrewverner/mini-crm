<?php

namespace common\models;

use common\enums\TicketStatusEnum;
use common\events\TicketEventListener;
use common\services\TicketChangelogServiceInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int $status
 * @property string $name
 * @property string $phone
 * @property string $title
 * @property string $comment
 * @property string $item
 * @property float|null $price
 * @property string $created_at
 */
class Ticket extends ActiveRecord
{
    public const array STATUS_MAP = [
        TicketStatusEnum::RECEIVED->value => 'Received',
        TicketStatusEnum::REJECTED->value => 'Rejected',
        TicketStatusEnum::DEFECT->value => 'Defect',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status'], 'integer'],
            [['name', 'phone', 'title', 'comment', 'item', 'created_at'], 'required'],
            [['comment'], 'string'],
            [['price'], 'number'],
            [['created_at'], 'safe'],
            [['name', 'title', 'item'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 11],
            [['phone'], 'validatePhone'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'name' => 'Client name',
            'phone' => 'Phone',
            'title' => 'Title',
            'comment' => 'Comment',
            'item' => 'Item',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }

    public function beforeValidate(): bool
    {
        if ($this->isNewRecord) {
            $this->created_at = new Expression(expression: 'NOW()');
            $this->status = TicketStatusEnum::RECEIVED->value;
        }

        return parent::beforeValidate();
    }

    public function validatePhone(): void
    {
        if (
            !is_numeric($this->phone)
            || !str_starts_with(haystack: $this->phone, needle: '7')
        ) {
            $this->addError(attribute: 'phone', error: 'Phone format is invalid');
        }
    }

    public function afterSave($insert, $changedAttributes): void
    {
        $service = Yii::$container->get(class: TicketChangelogServiceInterface::class);
        $service->logChanges(changedAttributes: $changedAttributes, ticket: $this);
    }
}
