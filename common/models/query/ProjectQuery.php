<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Project;
use yii\db\ActiveQuery;

class ProjectQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%project}}.status' => Project::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%project}}.published_at', time()]);
        return $this;
    }

    public function ignore($ids)
    {
        $this->andWhere('{{%project}}.id NOT IN (' . $ids . ')');

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function onlyCategory($ids)
    {
        if (!empty($ids)) {
            if (false === strpos($ids, ',')) {
                $this->leftJoin('{{project_categories}}', '{{project_categories}}.project_id = {{%project}}.id');
                $this->andWhere('{{project_categories.category_id}} = "' . $ids . '"');
            } else {
                $arr = explode(',', $ids);
                $this->leftJoin('{{project_categories}}', '{{project_categories}}.project_id = {{%project}}.id');
                $this->andWhere('{{project_categories.category_id}} in ("' . implode('","', $arr) . '")');
            }

            $this->groupBy(['{{%project}}.id']);
        }

        return $this;
    }

    /**
     *
     * @return $this
     */
    public function bothCategory($ids)
    {
        if (!empty($ids)) {
            if (false !== strpos($ids, ',')) {
                $arr = explode(',', $ids);

                foreach ($arr as $key => $value) {
                    $this->leftJoin('{{project_categories}} as pc' . $key, 'pc' . $key . '.project_id = {{%project}}.id');
                    $this->andWhere('pc' . $key . '.category_id = "' . $value . '"');
                }
            }
            else {
                $this->leftJoin('{{project_categories}}', '{{project_categories}}.project_id = {{%project}}.id');
                $this->andWhere('{{project_categories.category_id}} = "' . $ids . '"');
            }

            $this->groupBy(['{{%project}}.id']);
        }

        return $this;
    }
}