<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\models\query\PageQuery;
use \yii\helpers\ArrayHelper;
use common\models\Article;
use common\models\Project;
use \yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Cookie;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property string $head
 * @property string $body
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Page extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            'slug' => [
                'class'        => SluggableBehavior::className(),
                'attribute'    => 'title',
                'ensureUnique' => true,
                'immutable'    => true
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['head', 'body'], 'required'],
            [['body', 'head'], 'string'],
            [['status'], 'integer'],
            ['slug', 'unique', 'targetAttribute' => ['slug', 'locale']],
            [['slug'], 'string', 'max' => 2048],
            [['title'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'     => Yii::t('common', 'ID'),
            'slug'   => Yii::t('common', 'Slug'),
            'title'  => Yii::t('common', 'Title'),
            'body'   => Yii::t('common', 'Body'),
            'head'   => Yii::t('common', 'Head'),
            'status' => Yii::t('common', 'Active'),
        ];
    }

    /**
     * @return ArticleQuery
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }

    public static function getMetaTags()
    {
        $tags   = [];
        $locale = null;

        $arr = self::parseUrl(Yii::$app->request->pathInfo);

        if (!empty($arr[0]) and ! empty($arr[1]) and ! empty($arr[2]) and ! empty($arr[3])) {
            $shortLocale = $arr[0];
            $controller  = $arr[1];
            $action      = $arr[2];
            $slug        = $arr[3];

            foreach (Yii::$app->params['availableLocales'] as $k => $v) {
                if ($shortLocale == explode('-', $k)[0]) {
                    $locale = $k;
                }
            }

            switch ($controller) {
                case 'page':
                    $model = self::find()->published()->andWhere(['slug' => $slug, 'locale' => $locale])->one();

                    break;
                case 'article':
                    $model = Article::find()->published()->andWhere(['slug' => $slug, 'locale' => $locale])->one();
                    break;
                case 'promo':
                    //$model = Promo::find()->published()->andWhere(['slug' => $slug, 'locale' => $locale])->one();
                    break;
                case 'project':
                    $model = Project::find()->published()->andWhere(['slug' => $slug, 'locale' => $locale])->one();
                    break;
            }

            //hardcore :) json to array
            if (!empty($model) and ! empty($model->head)) {
                $arr = json_decode($model->head, true);
                foreach ($arr as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        //custom meta tag
                        if (4 == count($value2)) {
                            $value2 = array_values($value2);
                            $value2 = [$value2[0] => $value2[1], $value2[2] => $value2[3]];
                        }

                        $tags[] = $value2;
                    }
                }
            }

            if (empty($model)) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }

            if (!empty($tags[0]) and ! empty($tags[0]['name']) and 'title' == !empty($tags[0]['name']) and
                ! empty($tags[0]['content'])) {
                Yii::$app->view->title = $tags[0]['content'];
            } else {
                Yii::$app->view->title = $model->title;
            }
            
        }
        return $tags;
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

    public static function getSlugByLocaleGroupId($gid)
    {
        $model = self::find()->andWhere([
                'locale_group_id' => $gid,
                'locale'          => Yii::$app->language
            ])->one();

        return $model->slug;
    }

    public function afterDelete()
    {
        Page::deleteAll(['locale_group_id' => $this->locale_group_id]);

        return parent::afterDelete();
    }

    public static function switchToUrlLocale()
    {
        $arr = self::parseUrl(Yii::$app->request->pathInfo);

        $shortLocale = $arr[0];
        $controller  = $arr[1];
        $action      = $arr[2];
        $slug        = $arr[3];

        foreach (Yii::$app->params['availableLocales'] as $key => $value) {
            if ($shortLocale == explode('-', $key)[0]) {
                $locale = $key;
            }
        }

        if (empty($locale)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($locale == Yii::$app->language) {
            //current language = requested
            return true;
        }

        if (empty(Yii::$app->params['availableLocales'])) {
            //not aviable locale
            return true;
        }

        $cookie = new Cookie([
            'name'   => '_locale',
            'value'  => $locale,
            'expire' => time() + 60 * 60 * 24 * 365,
            'domain' => '',
        ]);

        Yii::$app->getResponse()->getCookies()->add($cookie);
        Yii::$app->language = $locale;
    }

    public static function parseUrl($url)
    {
        $arr = explode('/', trim($url, '/'));

        switch (count($arr)) {
            case '1':
                if (empty($arr[0])) {
                    // empty url, default uk
                    $arr[0] = 'ru';
                    $arr[1] = 'page';
                    $arr[2] = 'view';
                    $arr[3] = 'home';
                } else {
                    // /ru
                    $arr[0] = $arr[0];
                    $arr[1] = 'page';
                    $arr[2] = 'view';
                    $arr[3] = 'home';
                }
                break;
            case '2':
                //set default controller/action
                //ru/news
                $arr[3] = $arr[1];
                $arr[1] = 'page';
                $arr[2] = 'view';
                break;
            case '3':
                //set default controller/action
                ///ru/article/news-1
                $arr[3] = $arr[2];
                $arr[2] = 'view';
                break;
        }

        return $arr;
    }
}