<?php

namespace app\models\settings;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\settings\Modules;

/**
 * ModulesSearch represents the model behind the search form of `backend\models\settings\Modules`.
 */
class ModulesSearch extends Modules
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_gen'], 'integer'],
            [['name', 'label', 'name_db', 'view_col', 'model', 'controller', 'fa_icon', 'created_at', 'updated_at'], 'safe'],
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
        $query = Modules::find();

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
            'is_gen' => $this->is_gen,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'label', $this->label])
            ->andFilterWhere(['like', 'name_db', $this->name_db])
            ->andFilterWhere(['like', 'view_col', $this->view_col])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'controller', $this->controller])
            ->andFilterWhere(['like', 'fa_icon', $this->fa_icon]);

        return $dataProvider;
    }
}
