<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/4/14
 * Time: 2:31 PM
 */

namespace common\models\query;

use common\models\WidgetText;
use yii\db\ActiveQuery;

class WidgetTextQuery extends ActiveQuery
{
    public function published()
    {
        $this->andWhere(['{{%widget_text}}.status' => WidgetText::STATUS_ACTIVE]);
        $this->andWhere(['<', '{{%widget_text}}.created_at', time()]);
        return $this;
    }
}
