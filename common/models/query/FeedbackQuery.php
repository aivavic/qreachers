<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Feedback;
use yii\db\ActiveQuery;

class FeedbackQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%feedback}}.status' => Feedback::STATUS_PUBLISHED]);
        //$this->andWhere(['<', '{{%feedback}}.published_at', time()]);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignore($ids)
    {
        $this->andWhere('{{%feedback}}.id NOT IN (' . $ids . ')');

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignoreCategory($ids)
    {
        if (!empty($ids)) {
            $this->andWhere('{{%feedback}}.category_id NOT IN (' . $ids . ')');
        }

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function onlyCategory($ids)
    {
        if (!empty($ids)) {
            $this->andWhere('{{%feedback}}.category_id IN (' . $ids . ')');
        }

        return $this;
    }

}