<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Page;
use yii\db\ActiveQuery;

class PageQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%page}}.status' => Page::STATUS_PUBLISHED]);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignore($ids)
    {
        $this->andWhere('{{%page}}.id NOT IN (' . $ids . ')');

        return $this;
    }    
}