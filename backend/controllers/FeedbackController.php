<?php

namespace backend\controllers;

use Yii;
use common\models\Feedback;
use backend\models\search\FeedbackSearch;
use \common\models\FeedbackCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FeedbackController implements the CRUD actions for Feedback model.
 */
class FeedbackController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * Lists all Feedback models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder'=>['published_at'=>SORT_DESC]
        ];
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Feedback model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => FeedbackCategory::find()->active()->all(),
                'domains' => array_combine(explode(',', Yii::getAlias('@frontendUrls')), explode(',', Yii::getAlias('@frontendUrls'))),
            ]);
        }
    }

    public function actionEnum($domain_type)
    {
        $membersArray = Feedback::find()->published()->andWhere(['like', 'domain', Yii::getAlias('@frontendUrl_'.$domain_type)])->all();

        $enum       = [];
        $enumTitles = [];
        foreach ($membersArray as $k => $v) {
            $enum[] = $v->title.' #' .$v->id;
        }

        //\yii\helpers\VarDumper::dump($members,11,1); die();
        Yii::$app->response->data = [
            "items" => [
                "type" => "string",
                "enum" => $enum
            ]
        ];

        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        return Yii::$app->response;
    }
    
    
    /**
     * Updates an existing Feedback model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(!empty($model->domain)) {
                $model->domain = explode(',', $model->domain);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => FeedbackCategory::find()->active()->all(),
                'domains'    => array_combine(explode(',', Yii::getAlias('@frontendUrls')), explode(',', Yii::getAlias('@frontendUrls'))),
            ]);
        }
    }

    /**
     * Deletes an existing Feedback model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Feedback model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Feedback the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Feedback::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
