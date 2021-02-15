<?php

namespace app\modules\orders\models\orders;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\modules\orders\models\orders\Orders;
use app\modules\orders\models\services\Services;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\orders\models\orders\Orders`.
 */
class OrdersSearch extends Orders
{
    public const SEARCH_TYPE_ID = 1;
    public const SEARCH_TYPE_LINK = 2;
    public const SEARCH_TYPE_USERNAME = 3;

    /**
     * @var string to search
     */
    public $search;

    /**
     * @var int type of searching field
     */
    public $search_type;

    /**
     * @return array with search types as keys and text representation as values
     */
    public static function getSearchTypes()
    {
        return [
            self::SEARCH_TYPE_ID => Yii::t('app', 'orders.search.types.id'),
            self::SEARCH_TYPE_LINK => Yii::t('app', 'orders.search.types.link'),
            self::SEARCH_TYPE_USERNAME => Yii::t('app', 'orders.search.types.username'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'status', 'mode', 'search_type'], 'integer'],
            [['link', 'search'], 'safe'],

            ['status', 'in', 'range' => array_keys(Orders::getStatuses())],
            ['mode', 'in', 'range' => array_keys(Orders::getModes())],
            ['search_type', 'in', 'range' => array_keys(self::getSearchTypes())]
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
     * Builds query for searching
     * 
     * @param array $params for filtering
     *
     * @return OrdersQuery with filters applied
     */
    public function buildQuery(array $params)
    {
        $this->load($params, '');

        $query = Orders::find();
        $query->orderBy('id DESC');
        $query->joinWith('user');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $query;
        }

        // filtering conditions
        $query->andFilterWhere([
            'service_id' => $this->service_id,
            'status' => $this->status,
            'mode' => $this->mode,
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

        return $query;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params for filtering
     *
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        return new ActiveDataProvider([
            'query' => $this->buildQuery($params),
            'pagination' => ['pageSize' => 100],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => ['id']
            ]
        ]);
    }

    /**
     * @return array with modes for statuses filter
     */
    public function getModesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.modes.all'),
                'url' => Url::current(['mode' => null]),
                'options' => [
                    'class' => $this->mode === null ? 'active' : ''
                ]
            ]
        ];

        foreach (Orders::getModes() as $key => $value) {
            array_push($items, [
                'label' => $value,
                'url' => Url::current(['mode' => $key]),
                'options' => [
                    'class' => $this->mode === strval($key) ? 'active' : ''
                ]
            ]);
        }

        return $items;
    }

    /**
     * @return array with items for statuses filter
     */
    public function getStatusesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.statuses.all'),
                'url' => Url::current([
                    'status' => null,
                    'mode' => null,
                    'service_id' => null
                ]),
                'active' => $this->status === null
            ]
        ];

        foreach (Orders::getStatuses() as $key => $value) {
            array_push($items, [
                'label' => $value,
                'url' => Url::current([
                    'status' => $key,
                    'mode' => null,
                    'service_id' => null
                ]),
                'active' => $this->status === strval($key)
            ]);
        }

        return $items;
    }

    /**
     * @return array with items for services filter
     */
    public function getServicesFilterItems(): array
    {
        $items = [
            [
                'label' => Yii::t('app', 'orders.services.all') .
                    ' (' . Orders::getTotalCount() . ')',
                'url' => Url::current(['service_id' => null]),
                'options' => [
                    'class' => $this->service_id === null ? 'active' : ''
                ]
            ]
        ];

        foreach (Services::find()->all() as $item) {
            array_push($items, [
                'label' => '<span class="label-id">' .
                    $item->ordersCount . '</span> ' . $item->name,
                'url' => Url::current(['service_id' => $item->id]),
                'options' => [
                    'class' => $this->service_id === strval($item->id)
                        ? 'active' : ''
                ]
            ]);
        }
        ArrayHelper::multisort($items, 'count', SORT_DESC);

        return $items;
    }
}
