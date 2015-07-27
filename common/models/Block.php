<?php

namespace common\models;

use common\models\query\BlockQuery;
use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "block".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $description 
 * @property string $body 
 * @property string $locale
 * @property string $domain
 * @property integer $status  
 * @property integer $locale_group_id  
 */
class Block extends \yii\db\ActiveRecord
{
    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT     = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%block}}';
    }

    /**
     * @return BlockQuery
     */
    public static function find()
    {
        return new BlockQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class'     => SluggableBehavior::className(),
                'attribute' => 'title',
                'immutable' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['slug', 'unique', 'targetAttribute' => ['slug', 'locale']],
            [['title', 'description', 'body',], 'string'],
            [['status', 'locale_group_id'], 'integer'],
            [['domain'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('common', 'ID'),
            'slug'        => Yii::t('common', 'Slug'),
            'title'       => Yii::t('common', 'Title'),
            'description' => Yii::t('common', 'Description'),
            'body'        => Yii::t('common', 'Body'),
            'status'      => Yii::t('common', 'Published'),
            'domain'      => Yii::t('common', 'Domain')
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

    public function afterSave($insert, $changedAttributes)
    {
        return parent::afterSave($insert, $changedAttributes);
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
        Block::deleteAll(['locale_group_id' => $this->locale_group_id]);

        return parent::afterDelete();
    }
}