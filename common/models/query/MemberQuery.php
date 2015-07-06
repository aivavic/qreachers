<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Member;
use yii\db\ActiveQuery;

class MemberQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%member}}.status' => Member::STATUS_PUBLISHED]);
        //$this->andWhere(['<', '{{%member}}.published_at', time()]);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignore($ids)
    {
        $this->andWhere('{{%member}}.id NOT IN (' . $ids . ')');

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignoreCategory($ids)
    {
        if (!empty($ids)) {
            $this->andWhere('{{%member}}.category_id NOT IN (' . $ids . ')');
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
            $this->andWhere('{{%member}}.category_id IN (' . $ids . ')');
        }

        return $this;
    }

}