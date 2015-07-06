<?php

namespace backend\controllers;

use Yii;
use common\models\Member;
use backend\models\search\MemberSearch;
use \common\models\MemberCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
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
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel        = new MemberSearch();
        $dataProvider       = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC]
        ];
        return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionEnum()
    {
        $membersArray = Member::find()->published()->all();

        $enum       = [];
        $enumTitles = [];
        foreach ($membersArray as $k => $v) {
            $title  = $v->firstname . ' ' . $v->lastname . ' (' . $v->position . ') #' .$v->id;
            $enum[] = $title ;
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
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                    'model'      => $model,
                    'categories' => MemberCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                    'model'      => $model,
                    'categories' => MemberCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
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
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}