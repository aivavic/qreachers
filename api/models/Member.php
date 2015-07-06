<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Member extends \common\models\Member implements Linkable
{
    public function fields()
    {
        return ['id', 'category_id', 'title', 'head', 'body', 'published_at', 'thumbnail_base_url','thumbnail_path',  'firstname' , 'lastname', 'position', 'locale', 'gender', 'video', 'video_mobile', 'status_home'];
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
            Link::REL_SELF => Url::to(['member/view', 'id' => $this->id], true)
        ];
    }
}
