<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Client extends \common\models\Client implements Linkable
{
    public function fields()
    {
        return ['id', 'slug', 'category_id', 'title', 'head', 'body', 'published_at', 'thumbnail_base_url','thumbnail_path'];
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
            Link::REL_SELF => Url::to(['client/view', 'id' => $this->id], true)
        ];
    }
}
