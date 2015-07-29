<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\Article;
use yii\db\ActiveQuery;

class ArticleQuery extends ActiveQuery
{

    public function published()
    {
        $this->andWhere(['{{%article}}.status' => Article::STATUS_PUBLISHED]);
        $this->andWhere(['<', '{{%article}}.published_at', time()]);
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
                $this->leftJoin('{{article_categories}}', '{{article_categories}}.article_id = {{%article}}.id');
                $this->andWhere('{{article_categories.category_id}} = "' . $ids . '"');
            } else {
                $arr = explode(',', $ids);
                $this->leftJoin('{{article_categories}}', '{{article_categories}}.article_id = {{%article}}.id');
                $this->andWhere('{{article_categories.category_id}} in ("' . implode('","', $arr) . '")');
            }
        }







        return $this;
    }
}