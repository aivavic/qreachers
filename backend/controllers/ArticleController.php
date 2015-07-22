<?php

namespace backend\controllers;

use Yii;
use common\models\Article;
use backend\models\search\ArticleSearch;
use \common\models\ArticleCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\base\MultiModel;
use common\models\ArticleCategories;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ]
            ]
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel        = new ArticleSearch();
        $dataProvider       = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC]
        ];

        $dataProvider->query->andFilterWhere([ 'locale' => Yii::$app->language]);

        return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        foreach (Yii::$app->params['availableLocales'] as $key => $value) {
            $currentModel         = Article::getLocaleInstance($key);
            $currentModel->locale = $key;
            //$currentModel->title  = 'title ' . $key . ' ' . time();
            $models[$key]         = $currentModel;
        }

        $model = new MultiModel([
            'models' => $models
        ]);

        if ($model->load(Yii::$app->request->post()) && Article::multiSave($model)) {
            return $this->redirect(['index']);
        } else {
            //print_r(array_combine(explode(',', Yii::getAlias('@frontendUrls')), explode(',', Yii::getAlias('@frontendUrls'))));
            //die()
            return $this->render('create', [
                    'model'      => $model,
                    'categories' => ArticleCategory::find()->active()->all(),
                    'domains' => array_combine(explode(',', Yii::getAlias('@frontendUrls')), explode(',', Yii::getAlias('@frontendUrls')))
            ]);
        }
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $firstModel = $this->findModel($id);

        foreach (Yii::$app->params['availableLocales'] as $key => $value) {
            $currentModel              = Article::getLocaleInstance($key);
            $dataModel                 = $currentModel::find()
                ->andWhere([
                    'locale_group_id' => $firstModel->locale_group_id,
                    'locale'          => $key
                ])
                ->one();
            $dataModel->categoriesList = $this->getCategoriesListIds($dataModel->id);
            
            if(!empty($dataModel->domain)) {
                $dataModel->domain = explode(',', $dataModel->domain);
            }

            $models[$key]              = $dataModel;

            if (!$models[$key]) {
                $currentModel->attributes      = $firstModel->attributes;
                $currentModel->attachments     = $firstModel->attachments;
                $currentModel->thumbnail       = $firstModel->thumbnail;
                $currentModel->image           = $firstModel->image;
                $currentModel->categoriesList  = $firstModel->categoriesList;
                //$currentModel->video = $firstModel->video;
                $currentModel->locale_group_id = $firstModel->locale_group_id;
                $currentModel->locale          = $key;
                $currentModel->title           = 'title ' . $key . ' ' . time();
                $currentModel->slug            = '';

                $models[$key] = $currentModel;
            }
        }

        $model = new MultiModel([
            'models' => $models
        ]);

        if ($model->load(Yii::$app->request->post()) && Article::multiSave($model)) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'model'      => $model,
                    'categories' => ArticleCategory::find()->active()->all(),
                    'domains'    => array_combine(explode(',', Yii::getAlias('@frontendUrls')), explode(',', Yii::getAlias('@frontendUrls')))
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
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
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getCategoriesListIds($id)
    {
        $arr = [];

        $models = ArticleCategories::find()->andWhere(['article_id' => $id])->all();

        foreach ($models as $model) {
            $arr[] = $model->category_id;
        }

        return $arr;
    }
}