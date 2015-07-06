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

    /**
     *
     * @return $this
     */
    public function onlyCategory($ids)
    {
        if (!empty($ids)) {
            $this->leftJoin('{{project_categories}}', '{{project_categories}}.project_id = {{%project}}.id');
            $this->andWhere('{{project_categories.category_id}} = "'.$ids.'"');
        }

        return $this;
    }
}