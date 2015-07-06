<?php

namespace common\models;
use common\models\Project;
use common\models\ProjectCategory;

use Yii;

/**
 * This is the model class for table "{{%project_attachment}}".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $category_id
 *
 *
 * @property Project $project
 */
class ProjectCategories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'category_id'], 'required'],
            [['project_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'project_id' => Yii::t('common', 'Project ID'),
            'category_id' => Yii::t('common', 'Category ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProjectCategory::className(), ['id' => 'category_id']);
    }
}
