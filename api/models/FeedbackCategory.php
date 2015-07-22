<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class FeedbackCategory extends \common\models\FeedbackCategory implements Linkable
{

    public function fields()
    {
        return ['id', 'slug', 'title', 'weight'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['api/v1/feedback-category/view', 'id' => $this->id], true)
        ];
    }
}