<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Block extends \common\models\Block implements Linkable
{
    public function fields()
    {
        return ['id', 'slug', 'title', 'description', 'body', 'domain', 'locale', 'locale_group_id'];
    }

    public function extraFields()
    {
        return [];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['block/view', 'id' => $this->id], true)
        ];
    }
}
