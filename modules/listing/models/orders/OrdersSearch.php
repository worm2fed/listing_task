<?php

namespace app\modules\listing\models\orders;

use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\modules\listing\models\orders\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\listing\models\orders\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'service_id', 'status', 'mode'], 'integer'],
            [['link', 'username'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params, '');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'service_id' => $this->service_id,
            'status' => $this->status,
            'mode' => $this->mode,
        ]);

        $query->andFilterWhere(['like', 'link', $this->link]);

        // $query->andWhere(
        //     'user.first_name LIKE "%' . $this->username . '%" ' .
        //         'OR user.last_name LIKE "%' . $this->username . '%"'
        // );

        return $dataProvider;
    }
}
