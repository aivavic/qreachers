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

        preg_match('/^(.+)\/(.+)\/(.+)\/(.+)/', Yii::$app->request->pathInfo, $matches);

        if (!empty($matches[1]) and ! empty($matches[2]) and ! empty($matches[3])) {
            $shortLocale = $matches[1];
            $controller  = $matches[2];
            $action      = $matches[3];
            $slug        = $matches[4];

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

            Yii::$app->view->title = $model->title;
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

    public static function switchToUrlLocale()
    {
        /* if ('site' == Yii::$app->controller->id and 'set-locale' == Yii::$app->controller->action->id) {
          return;
          } */

        $url = Yii::$app->request->pathInfo;

        $arr = explode('/', $url);

        if (!empty($arr[0]) and ! empty($arr[1]) and ! empty($arr[2]) and ! empty($arr[3])) {
            $locale     = $arr[0];
            $controller = $arr[1];
            $action     = $arr[2];
            $slug       = $arr[3];

            if ($locale != explode('-', Yii::$app->language)[0]) {
                //echo $locale . '!=' . explode('-', Yii::$app->language)[0]; die();
                $_SESSION['altRef'] = Yii::$app->request->absoluteUrl;
                Yii::$app->response->redirect(Url::to(['/site/set-locale', 'locale' => $locale]));
            }
        } else {
            //$_SESSION['altRef'] = Yii::$app->request->absoluteUrl;

            if (!empty($arr[0]) and 'en' == $arr[0]) {
                //Yii::$app->request->referrer = '/en/page/view/home';
                $_SESSION['altRef'] = Yii::$app->request->absoluteUrl . '/page/view/home';
                Yii::$app->response->redirect(Url::to(['/site/set-locale', 'locale' => 'en-US']));
            } elseif (!empty($arr[0]) and 'ru' == $arr[0]) {
                $_SESSION['altRef'] = Yii::$app->request->absoluteUrl . '/page/view/home';
                Yii::$app->response->redirect(Url::to(['/site/set-locale', 'locale' => 'ru-RU']));
            } else {
                Yii::$app->response->redirect(Url::to(['/site/set-locale', 'locale' => Yii::$app->language]));
            }
        }
    }
}