<?php

namespace frontend\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error'      => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha'    => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            /*'set-locale' => [
                'class'   => 'common\actions\SetLocaleAction',
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]*/
        ];
    }

    public function actionIndex()
    {
        //$verbs        
        $this->layout = '@frontend/views/layouts/main.php';
        return $this->render('index');
    }

    public function actionMessage($message)
    {
        return $this->render('message',[
            'message' => $message,
        ]);
    }
    
    public function actionFeedback()
    {
        var_dump($_POST);
    }
}