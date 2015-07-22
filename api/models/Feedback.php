<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Feedback extends \common\models\Feedback implements Linkable
{
    public function fields()
    {
        return ['id', 'nick', 'email', 'message', 'lang'];
    }

    public function extraFields()
    {
        return ['category'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['feedback/view', 'id' => $this->id], true)
        ];
    }
}
