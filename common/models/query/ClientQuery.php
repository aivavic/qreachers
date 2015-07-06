<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Client;
use yii\db\ActiveQuery;

class ClientQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%client}}.status' => Client::STATUS_PUBLISHED]);
        //$this->andWhere(['<', '{{%client}}.published_at', time()]);
        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignore($ids)
    {
        $this->andWhere('{{%client}}.id NOT IN (' . $ids . ')');

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function ignoreCategory($ids)
    {
        if (!empty($ids)) {
            $this->andWhere('{{%client}}.category_id NOT IN (' . $ids . ')');
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
            $this->andWhere('{{%client}}.category_id IN (' . $ids . ')');
        }

        return $this;
    }

}