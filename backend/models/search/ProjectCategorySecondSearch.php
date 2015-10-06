<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProjectCategorySecond;

/**
 * ProjectCategorySecondSearch represents the model behind the search form about `common\models\ProjectCategorySecond`.
 */
class ProjectCategorySecondSearch extends ProjectCategorySecond
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['slug', 'title','weight','locale'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProjectCategorySecond::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'locale', $this->locale]);

        return $dataProvider;
    }
}
