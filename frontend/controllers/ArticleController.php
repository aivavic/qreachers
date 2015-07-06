<?php

namespace frontend\controllers;


use yii\web\Controller;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class ArticleController extends Controller
{

    /**
     * @return string
     */
    public function actionIndex()
    {        
        return $this->render('index/index');
    }

    /**
     * @param $slug
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView()
    {
        return $this->render('view/view');
    }
}