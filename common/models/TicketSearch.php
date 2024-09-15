<?php

declare(strict_types=1);

namespace common\models;

use yii\data\ActiveDataProvider;

class TicketSearch extends Ticket
{
    public function rules(): array
    {
        return [
            [['name', 'phone'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = Ticket::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
