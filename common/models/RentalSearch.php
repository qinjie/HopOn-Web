<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rental;

/**
 * RentalSearch represents the model behind the search form about `common\models\Rental`.
 */
class RentalSearch extends Rental
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'bicycle_id', 'return_station_id', 'duration', 'created_at', 'updated_at'], 'integer'],
            [['serial', 'book_at', 'pickup_at', 'return_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Rental::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'bicycle_id' => $this->bicycle_id,
            'book_at' => $this->book_at,
            'pickup_at' => $this->pickup_at,
            'return_at' => $this->return_at,
            'return_station_id' => $this->return_station_id,
            'duration' => $this->duration,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'serial', $this->serial]);

        return $dataProvider;
    }
}
