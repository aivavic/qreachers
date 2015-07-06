<?php

namespace api\controllers\db;

use Yii;
use api\models\Client;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class ClientController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ClientController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\models\Client';

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
        $limit          = Yii::$app->request->get('limit', 20);
        $ignore         = Yii::$app->request->get('ignore', 0);
        $ignoreCategory = Yii::$app->request->get('ignore_category_id');
        $onlyCategory   = Yii::$app->request->get('category_id');
        $where          = Yii::$app->request->get('where', []);

        return new ActiveDataProvider(array(
            'query'      => Client::find()
                ->published()
                ->ignore($ignore)
                ->ignoreCategory($ignoreCategory)
                ->onlyCategory($onlyCategory)
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
        $model = Client::find()
            ->published()
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}