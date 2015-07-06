<?php

namespace api\controllers\db;

use Yii;
use api\models\WidgetText;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class ArticleController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class WidgetTextController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\models\WidgetText';

    /**
     * @var array
     */
    public $serializer = [
        'class'              => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items'
    ];

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index'   => [
                'class'               => 'yii\rest\IndexAction',
                'modelClass'          => $this->modelClass,
                'prepareDataProvider' => [$this, 'prepareDataProvider']
            ],
            'view'    => [
                'class'      => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel'  => [$this, 'findModel']
            ],
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ]
        ];
    }

    /**
     * @return ActiveDataProvider
     */
    public function prepareDataProvider()
    {
        $where = Yii::$app->request->get('where', []);
        $limit = Yii::$app->request->get('limit', 20);

        return new ActiveDataProvider(array(
            'query'      => WidgetText::find()
                ->published()
                ->andFilterWhere($where),
            'pagination' => [
                'pageSize' => $limit,
            ]
        ));
    }

    /**
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     * @throws HttpException
     */
    public function findModel($id)
    {
        $model = WidgetText::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->orWhere(['key' => $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}