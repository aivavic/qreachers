<?php

namespace common\models;

use common\models\query\ProjectQuery;
use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\ProjectCategories;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property string $head
 * @property string $body
 * @property string $thumbnail_base_url
 * @property string $thumbnail_path
 * @property string $video_base_url
 * @property string $video_path
 * @property string $domain
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
 * @property ProjectCategory $category
 * @property ProjectAttachment[] $projectAttachments
 */
class Project extends \yii\db\ActiveRecord
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
    public $categoriesList;

    /**
     * @var array
     */
    public $thumbnail;

    /**
     * @var array
     */
    public $video;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @return ProjectQuery
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
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
            [
                'class'     => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true
            ],
            [
                'class'          => UploadBehavior::className(),
                'attribute'      => 'attachments',
                'multiple'       => true,
                'uploadRelation' => 'projectAttachments'
            ],
            [
                'class'            => UploadBehavior::className(),
                'attribute'        => 'thumbnail',
                'pathAttribute'    => 'thumbnail_path',
                'baseUrlAttribute' => 'thumbnail_base_url'
            ],
            [
                'class'            => UploadBehavior::className(),
                'attribute'        => 'video',
                'pathAttribute'    => 'video_path',
                'baseUrlAttribute' => 'video_base_url'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['slug', 'unique', 'targetAttribute' => ['slug', 'locale']],
            [['body', 'head'], 'string'],
            //[['published_at'], 'default', 'value' => time()],
            //[['published_at'], 'filter', 'filter' => 'strtotime'],
            [['category_id'], 'exist', 'targetClass' => ProjectCategory::className(), 'targetAttribute' => 'id'],
            [['author_id', 'updater_id', 'status', 'weight'], 'integer'],
            [['slug', 'thumbnail_base_url', 'thumbnail_path', 'video_base_url', 'video_path', 'published_at'], 'string', 'max' => 1024],
            [['title', 'description'], 'string', 'max' => 512],
            [['attachments', 'thumbnail', 'video', 'categoriesList', 'domain'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('common', 'ID'),
            'slug'           => Yii::t('common', 'Slug'),
            'title'          => Yii::t('common', 'Title'),
            'description'    => Yii::t('common', 'Description'),
            'head'           => Yii::t('common', 'Head'),
            'body'           => Yii::t('common', 'Body'),
            'thumbnail'      => Yii::t('common', 'Thumbnail'),
            'video'          => Yii::t('common', 'Main image'),
            'author_id'      => Yii::t('common', 'Author'),
            'updater_id'     => Yii::t('common', 'Updater'),
            'category_id'    => Yii::t('common', 'Category'),
            'status'         => Yii::t('common', 'Published'),
            'published_at'   => Yii::t('common', 'Published At'),
            'created_at'     => Yii::t('common', 'Created At'),
            'updated_at'     => Yii::t('common', 'Updated At'),
            'weight'         => Yii::t('common', 'Weight'),
            'categoriesList' => Yii::t('common', 'Categories list'),
            'domain'         => Yii::t('common', 'Domain')
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {       
            if (!$this->published_at) {
                $this->published_at = $this->created_at;
            }
            else {
                $this->published_at = strtotime($this->published_at);
            }

            if ($this->domain) {
                $this->domain = implode(',', $this->domain);
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        //delete all categories relations
        $models = $this->getCategories()->all();

        foreach ($models as $model) {
            $model->delete();
        }

        if (!empty($this->categoriesList)) {
            //add new rows
            foreach ($this->categoriesList as $categoryId) {
                $model              = new ProjectCategories();
                $model->project_id  = $this->id;
                $model->category_id = $categoryId;
                $model->save();
            }
        }




        return parent::afterSave($insert, $changedAttributes);
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
        return $this->hasOne(ProjectCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(ProjectCategories::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectAttachments()
    {
        return $this->hasMany(ProjectAttachment::className(), ['project_id' => 'id']);
    }

    public static function getLocaleInstance($locale)
    {
        $name = self::getLocaleClassName($locale, self::getClassNameNoNamespace());
        return new $name();
    }

    public static function getClassNameNoNamespace()
    {
        return substr(
            self::className(), strrpos(self::className(), '\\') + 1
        );
    }

    public static function getLocaleClassName($locale, $className)
    {
        return str_replace(
            $className, 'locale\\' . $className . ucfirst(str_replace('-', '', $locale)), self::className()
        );
    }

    public static function getLastLocaleGroupId()
    {
        $model = self::find()->orderBy("locale_group_id DESC")->one();
        if ($model) {
            return $model->locale_group_id;
        } else {
            return 0;
        }
    }

    public static function multiSave($model)
    {

        //\yii\helpers\VarDumper::dump(Yii::$app->request->post(),11,1); die();

        $defaultAttributes = [];

        foreach ($model->getModels() as $key => $v) {

            foreach ($model->getModel($key)->attributes() as $attrKey) {
                if (empty($defaultAttributes[$attrKey])) {
                    $defaultAttributes[$attrKey] = $model->getModel($key)->$attrKey;
                }
            }
        }

        unset($defaultAttributes['id']);
        unset($defaultAttributes['locale']);
        unset($defaultAttributes['locale_group_id']);
        //unset($defaultAttributes['slug']);

        $groupId = self::getLastLocaleGroupId() + 1;

        foreach ($model->getModels() as $key => $v) {
            if (!$model->getModel($key)->locale_group_id) {
                $model->getModel($key)->locale_group_id = $groupId;
            }

            foreach ($defaultAttributes as $key2 => $value2) {
                if (empty($model->getModel($key)->$key2) or "[]" == $model->getModel($key)->$key2) {
                    $model->getModel($key)->$key2 = $value2;
                }
            }

            //\yii\helpers\VarDumper::dump($model->getModel($key),11,1);
        }


        return $model->save();
    }

    public function afterDelete()
    {
        Project::deleteAll(['locale_group_id' => $this->locale_group_id]);

        return parent::afterDelete();
    }
}