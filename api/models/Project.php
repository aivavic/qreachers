<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Project extends \common\models\Project implements Linkable
{
    public function fields()
    {
        return ['id', 'slug', 'category_id', 'title', 'body', 'published_at', 'thumbnail_base_url','thumbnail_path','video_base_url','video_path','description', 'domain'];
    }

    public function extraFields()
    {
        return ['category', 'categories', 'projectAttachments'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['project/view', 'id' => $this->id], true)
        ];
    }
}
