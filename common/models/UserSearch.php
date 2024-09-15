<?php

declare(strict_types=1);

namespace common\models;

use yii\data\ActiveDataProvider;

final class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['email'], 'safe'],
        ];
    }

    public function search($params): ActiveDataProvider
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
