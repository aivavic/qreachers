<?php

namespace api\controllers\db;

use Yii;
use api\models\Feedback;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

/**
 * Class FeedbackController
 * @author Eugene Terentev <eugene@terentev.net>
 */
class FeedbackController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = 'api\models\Feedback';

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
            /*'view'    => [
                'class'      => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'findModel'  => [$this, 'findModel']
            ],*/
            'update'  => [
                'class'      => 'yii\rest\UpdateAction',
                'modelClass' => $this->modelClass,
                'findModel'  => [$this, 'findModel']
            ],
            'create'  => [
                'class'      => 'yii\rest\CreateAction',
                'modelClass' => $this->modelClass,
                'findModel'  => [$this, 'findModel'],
                'scenario' => 'create'
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
        $where          = Yii::$app->request->get('where', []);

        return new ActiveDataProvider(array(
            'query'      => Feedback::find()                
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
        $model = Feedback::find()            
            ->andWhere(['id' => (int) $id])
            ->one();
        if (!$model) {
            throw new HttpException(404);
        }
        return $model;
    }
}