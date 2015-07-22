<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\FeedbackCategory;
use yii\db\ActiveQuery;

class FeedbackCategoryQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['{{%feedback_category}}.status' => FeedbackCategory::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%feedback_category}}.parent_id IS NULL');

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignore($ids)
    {
        $this->andWhere('{{%feedback_category}}.id NOT IN (' . $ids . ')');

        return $this;
    }
}
