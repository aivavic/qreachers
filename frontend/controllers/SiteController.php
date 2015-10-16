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
        $currentBrowser = $this->_getBrowser($_SERVER['HTTP_USER_AGENT']);        
        $badBrowsers    = file(Yii::getAlias('@frontend/config/badBrowserList.txt'));
        \yii\helpers\VarDumper::dump($currentBrowser, 11, 1);
        \yii\helpers\VarDumper::dump($badBrowsers, 11, 1);
        return;
        foreach ($badBrowsers as $key => $value) {
            $badBrowser        = trim(explode('<', $value)[0]);
            $badBrowserVersion = trim(explode('<', $value)[1]);

            if ($currentBrowser['browser'] == $badBrowser) {
                if (-1 == version_compare($currentBrowser['version'], $badBrowserVersion)) {                    
                    $this->redirect(Yii::getAlias('@frontendUrl/page/newbrowser.html'));
                }
            }
        }
    }

    private function _getBrowser($agent)
    {
        \yii\helpers\VarDumper::dump($agent, 11, 1);
        preg_match("/(MSIE|Opera|Firefox|Chrome|Version|Opera Mini|Netscape|Konqueror|SeaMonkey|Camino|Minefield|Iceweasel|K-Meleon|Maxthon)(?:\/| )([0-9.]+)/", $agent, $browser_info);
        \yii\helpers\VarDumper::dump($browser_info, 11, 1); return;
        list(, $browser, $version) = $browser_info;

        switch ($browser) {
            case 'MSIE':
                preg_match("/(Maxthon|Avant Browser|MyIE2)/i", $agent, $ie);
                if ($ie) {
                    $browser = 'unknown';
                    $version = $ie[1] . ' based on IE ' . $version;
                }

                $browser = 'IE';
                $version = $version;

                break;
            case 'Firefox':
                preg_match("/(Flock|Navigator|Epiphany)\/([0-9.]+)/", $agent, $ff);
                if ($ff) {
                    $browser = $ff[1];
                    $version = $ff[2];
                }

                break;
            case 'Opera':
                if ($version == '9.80') {
                    $browser = 'Opera';
                    $version = substr($agent, -5);
                }

                break;
            case 'Version':
                $browser = 'Safari';
                $version = $version;

                break;

            default:
                if (preg_match("/Opera ([0-9.]+)/i", $agent, $opera)) {
                    $browser = 'Opera';
                    $version = $opera[1];
                }

                if (!$browser && strpos($agent, 'Gecko')) {
                    $browser = 'unknown';
                    $version = 'Browser based on Gecko';
                }

                if (!$browser) {
                    $browser = 'unknown';
                }

                if (!$version) {
                    $version = 'unknown';
                }

                break;
        }

        return [
            'browser' => $browser,
            'version' => $version
        ];
    }
}