<?php

namespace common\models;

use common\models\query\FeedbackQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "feedback".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $domain
 * @property string $body
 * @property string $head
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property array $attachments
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $category_id
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $weight
 *
 * @property User $author
 * @property User $updater
 * @property FeedbackCategory $category
 * @property FeedbackAttachment[] $feedbackAttachments
 */
class Feedback extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT     = 0;

    /**
     * @var array
     */
    public $attachments;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @return FeedbackQuery
     */
    public static function find()
    {
        return new FeedbackQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class'              => BlameableBehavior::className(),
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
            /* [
              'class'     => SluggableBehavior::className(),
              'attribute' => 'title',
              'immutable' => true
              ], */
            [
                'class'          => UploadBehavior::className(),
                'attribute'      => 'attachments',
                'multiple'       => true,
                'uploadRelation' => 'feedbackAttachments'
            ],
            [
                'class'            => UploadBehavior::className(),
                'attribute'        => 'thumbnail',
                'pathAttribute'    => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['title'], 'required'],
            //[['slug'], 'unique'],
            [['body', 'head', 'nick', 'email', 'message', 'lang'], 'string'],
            [['published_at'], 'default', 'value' => time()],
            [['published_at'], 'filter', 'filter' => 'strtotime'],
            [['category_id'], 'exist', 'targetClass' => FeedbackCategory::className(), 'targetAttribute' => 'id'],
            [['author_id', 'updater_id', 'status', 'weight'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['attachments', 'thumbnail', 'domain'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('common', 'ID'),
            'slug'         => Yii::t('common', 'Slug'),
            'title'        => Yii::t('common', 'Title'),
            'head'         => Yii::t('common', 'Head'),
            'body'         => Yii::t('common', 'Body'),
            'thumbnail'    => Yii::t('common', 'Thumbnail'),
            'author_id'    => Yii::t('common', 'Author'),
            'updater_id'   => Yii::t('common', 'Updater'),
            'category_id'  => Yii::t('common', 'Category'),
            'status'       => Yii::t('common', 'Was sent?'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_at'   => Yii::t('common', 'Created At'),
            'updated_at'   => Yii::t('common', 'Updated At'),
            'weight'       => Yii::t('common', 'Weight'),
            'domain'       => Yii::t('common', 'Domain'),
            'nick'         => Yii::t('common', 'Nick'),
            'email'        => Yii::t('common', 'Email'),
            'message'      => Yii::t('common', 'Message'),
            'lang'         => Yii::t('common', 'Language'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->domain) {
                $this->domain = implode(',', $this->domain);
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(FeedbackCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFeedbackAttachments()
    {
        return $this->hasMany(FeedbackAttachment::className(), ['feedback_id' => 'id']);
    }
}