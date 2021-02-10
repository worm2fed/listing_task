<?php

namespace app\modules\listing\models\services;

use Yii;

use app\modules\listing\models\orders\Orders;


/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property string $name
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => Yii::t('listing', 'ID'),
            'name' => Yii::t('listing', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ServicesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ServicesQuery(get_called_class());
    }

    public function getOrders()
    {
        return $this->hasMany(
            Orders::class,
            ['service_id' => 'id']
        )->inverseOf('service');
    }

    public function getOrders_count()
    {
        return Orders::find()->where(['service_id' => $this->id])->count();
    }
}
