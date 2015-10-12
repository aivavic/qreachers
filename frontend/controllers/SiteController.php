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
            'error'   => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            /* 'set-locale' => [
              'class'   => 'common\actions\SetLocaleAction',
              'locales' => array_keys(Yii::$app->params['availableLocales'])
              ] */
        ];
    }

    public function actionIndex()
    {        
        $this->_checkBrowser();

        $this->layout = '@frontend/views/layouts/main.php';
        return $this->render('index');
    }

    public function actionMessage($message)
    {
        return $this->render('message', [
                'message' => $message,
        ]);
    }

    public function actionFeedback()
    {
        var_dump($_POST);
    }

    public function beforeAction($action)
    {
        if ($action->id == 'error') $this->layout = 'main.php';

        return parent::beforeAction($action);
    }

    private function _checkBrowser()
    {
        $badBrowsers = file(Yii::getAlias('@frontend/config/browserList.txt'));

        //\yii\helpers\VarDumper::dump($badBrowsers, 11, 1);
        //echo $_SERVER['HTTP_USER_AGENT'];
        if (in_array($_SERVER['HTTP_USER_AGENT'], $badBrowsers)) {
            $this->redirect(Yii::getAlias('@frontendUrl/page/newbrowser.html'));
        }
    }
}