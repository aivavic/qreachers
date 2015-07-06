<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class WidgetText extends \common\models\WidgetText implements Linkable
{
    public function fields()
    {
        return ['id','key', 'title', 'body'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['widget-text/view', 'id' => $this->id], true)
        ];
    }
}
