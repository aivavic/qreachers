<?php

namespace common\models;

use common\models\query\MemberQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
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
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $position
 * @property string $locale
 * @property integer $gender
 * @property string $video
 * @property string $video_mobile
 * @property integer $status_home
 *
 * @property User $author
 * @property User $updater
 * @property MemberCategory $category
 * @property MemberAttachment[] $memberAttachments
 */
class Member extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED      = 1;
    const STATUS_DRAFT          = 0;
    const STATUS_HOME_PUBLISHED = 1;
    const STATUS_HOME_DRAFT     = 0;
    const GENDER_MALE           = 1;
    const GENDER_FEMALE         = 2;

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
        return '{{%member}}';
    }

    /**
     * @return MemberQuery
     */
    public static function find()
    {
        return new MemberQuery(get_called_class());
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
            /*[
                'class'     => SluggableBehavior::className(),
                'attribute' => ['firstname', 'middlename', 'lastname'],
                'immutable' => true
            ],*/
            [
                'class'          => UploadBehavior::className(),
                'attribute'      => 'attachments',
                'multiple'       => true,
                'uploadRelation' => 'memberAttachments'
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
            [['firstname', 'lastname'], 'required'],
            [['slug'], 'unique'],
            [['body', 'head'], 'string'],
            [['published_at'], 'default', 'value' => time()],
            [['published_at'], 'filter', 'filter' => 'strtotime'],
            [['category_id'], 'exist', 'targetClass' => MemberCategory::className(), 'targetAttribute' => 'id'],
            [['author_id', 'updater_id', 'status', 'status_home', 'gender', 'weight'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 512],
            [['attachments', 'thumbnail'], 'safe'],
            [['gender'], 'in', 'range' => [self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'lastname', 'position', 'video', 'video_mobile'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
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
            'thumbnail'    => Yii::t('common', 'Photo'),
            'author_id'    => Yii::t('common', 'Author'),
            'updater_id'   => Yii::t('common', 'Updater'),
            'category_id'  => Yii::t('common', 'Category'),
            'status'       => Yii::t('common', 'Status'),
            'published_at' => Yii::t('common', 'Published At'),
            'created_at'   => Yii::t('common', 'Created At'),
            'updated_at'   => Yii::t('common', 'Updated At'),
            'weight'       => Yii::t('common', 'Weight'),
            'firstname'    => Yii::t('common', 'Firstname'),            
            'lastname'     => Yii::t('common', 'Lastname'),
            'locale'       => Yii::t('common', 'Locale'),
            'position'     => Yii::t('common', 'Position'),
            'gender'       => Yii::t('common', 'Gender'),
            'video'        => Yii::t('common', 'Video'),
            'video_mobile'        => Yii::t('common', 'Video mobile'),
            'status_home'  => Yii::t('common', 'Show on about page')
        ];
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
        return $this->hasOne(MemberCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberAttachments()
    {
        return $this->hasMany(MemberAttachment::className(), ['member_id' => 'id']);
    }
}