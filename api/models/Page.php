<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Page extends \common\models\Page implements Linkable
{
    public function fields()
    {
        return ['id', 'slug', 'title', 'head', 'body', 'created_at', 'updated_at'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['page/view', 'id' => $this->id], true)
        ];
    }
}
