<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%feedback_attachment}}".
 *
 * @property integer $id
 * @property integer $feedback_id
 * @property string $base_url
 * @property string $path
 * @property string $url
 * @property string $name
 * @property string $type
 * @property string $size
 *
 * @property Feedback $feedback
 */
class FeedbackAttachment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id', 'path'], 'required'],
            [['feedback_id', 'size'], 'integer'],
            [['base_url', 'path', 'type', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'feedback_id' => Yii::t('common', 'Feedback ID'),
            'base_url' => Yii::t('common', 'Base Url'),
            'path' => Yii::t('common', 'Path'),
            'size' => Yii::t('common', 'Size'),
            'type' => Yii::t('common', 'Type'),
            'name' => Yii::t('common', 'Name')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedback()
    {
        return $this->hasOne(Feedback::className(), ['id' => 'feedback_id']);
    }

    public function getUrl()
    {
        return $this->base_url .'/'. $this->path;
    }
}
