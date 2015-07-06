<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\base\Controller;

/**
 * @author Eugene Fabrikov efabrikov@gmail.com
 */
class SinglePageBehavior extends Behavior
{
    /**
     *
     * @var string
     */
    public $indexPage = '/site/index';

    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function beforeAction()
    {        
        if (!Yii::$app->request->isAjax and $this->indexPage != Url::toRoute('') ) {
            Yii::$app->response->redirect(Url::toRoute([$this->indexPage,'notAjaxQuery'=> Url::current()]));
        }
    }
}
