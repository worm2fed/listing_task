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
    public const SEARCH_TYPE_ID       = 1;
    public const SEARCH_TYPE_LINK     = 2;
    public const SEARCH_TYPE_USERNAME = 3;

    /**
     * @return array
     */
    public static function search_types()
    {
        return [
            self::SEARCH_TYPE_ID       => Yii::t('app', 'orders.search.types.id'),
            self::SEARCH_TYPE_LINK     => Yii::t('app', 'orders.search.types.link'),
            self::SEARCH_TYPE_USERNAME => Yii::t('app', 'orders.search.types.username'),
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
     * Builds query for searching
     * @param array $params
     *
     * @return \app\modules\orders\models\orders\OrdersQuery
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params)
    {
        return new ActiveDataProvider([
            'query'      => $this->buildQuery($params),
            'pagination' => ['pageSize' => 100],
            'sort'       => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes'   => ['id']
            ]
        ]);
    }

    /**
     * @return array
     */
    public function getStatusesFilterItems(): array
    {
        $items = [
            [
                'label'  => Yii::t('app', 'orders.statuses.all'),
                'url'    => Url::current([
                    'status'     => null,
                    'mode'       => null,
                    'service_id' => null
                ]),
                'active' => is_null($this->status)
            ]
        ];

        foreach (Orders::statuses() as $key => $value) {
            array_push($items, [
                'label'  => $value,
                'url'    => Url::current([
                    'status'     => $key,
                    'mode'       => null,
                    'service_id' => null
                ]),
                'active' => $this->status === strval($key)
            ]);
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getServicesFilterItems(): array
    {
        $items = [
            [
                'label'   => Yii::t('app', 'orders.services.all') .
                    ' (' . Orders::getTotal_count() . ')',
                'url'     => Url::current(['service_id' => null]),
                'options' => [
                    'class' => is_null($this->service_id) ? 'active' : ''
                ]
            ]
        ];

        foreach (Services::find()->all() as $item) {
            array_push($items, [
                'label'   => '<span class="label-id">' .
                    $item->orders_count . '</span> ' . $item->name,
                'url'     => Url::current(['service_id' => $item->id]),
                'options' => [
                    'class' => $this->service_id === strval($item->id)
                        ? 'active' : ''
                ]
            ]);
        }
        ArrayHelper::multisort($items, 'count', SORT_DESC);

        return $items;
    }

    /**
     * @return array
     */
    public function getModesFilterItems(): array
    {
        $items = [
            [
                'label'  => Yii::t('app', 'orders.modes.all'),
                'url'    => Url::current(['mode' => null]),
                'options' => [
                    'class' => is_null($this->mode) ? 'active' : ''
                ]
            ]
        ];

        foreach (Orders::modes() as $key => $value) {
            array_push($items, [
                'label'  => $value,
                'url'    => Url::current(['mode' => $key]),
                'options' => [
                    'class' => $this->mode === strval($key) ? 'active' : ''
                ]
            ]);
        }

        return $items;
    }
}
