<?php

namespace app\modules\orders\models\orders;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

use app\modules\orders\models\orders\Orders;


/**
 * OrdersSearch represents the model behind the search form of `app\modules\orders\models\orders\Orders`.
 */
class OrdersSearch extends Orders
{
    const SEARCH_TYPE_ID       = 1;
    const SEARCH_TYPE_LINK     = 2;
    const SEARCH_TYPE_USERNAME = 3;

    /**
     * @return array
     */
    public static function search_types()
    {
        return [
            self::SEARCH_TYPE_ID       => Yii::t('orders', 'Order ID'),
            self::SEARCH_TYPE_LINK     => Yii::t('orders', 'Link'),
            self::SEARCH_TYPE_USERNAME => Yii::t('orders', 'Username'),
        ];
    }

    public $search;
    public $search_type;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'status', 'mode', 'search_type'], 'integer'],
            [['link', 'search'], 'safe'],

            ['status', 'in', 'range' => array_keys(Orders::statuses())],
            ['mode', 'in', 'range' => array_keys(Orders::modes())],
            ['search_type', 'in', 'range' => array_keys(self::search_types())]
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
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'service_id' => $this->service_id,
            'status'     => $this->status,
            'mode'       => $this->mode,
        ]);

        if (isset($this->search_type) && isset($this->search)) {
            $this->search = trim($this->search);
            switch ($this->search_type) {
                case self::SEARCH_TYPE_ID:
                    $query->andFilterWhere(['id' => $this->search]);
                    break;
                case self::SEARCH_TYPE_LINK:
                    $query->andFilterWhere(['like', 'link', $this->search]);
                    break;
                case self::SEARCH_TYPE_USERNAME:
                    $query->joinWith(['user']);
                    $query->andFilterWhere([
                        'like',
                        'CONCAT_WS(" ", users.first_name, users.last_name)',
                        $this->search,
                    ]);
                    break;
                default:
                    break;
            }
        }

        return $dataProvider;
    }
}
