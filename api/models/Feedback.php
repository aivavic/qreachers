<?php

namespace api\models;

use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\Link;
use Yii;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class Feedback extends \common\models\Feedback implements Linkable
{

    public function fields()
    {
        return ['id', 'nick', 'email', 'message', 'lang'];
    }

    public function extraFields()
    {
        return ['category'];
    }

    /**
     * Returns a list of links.
     *
     * @return array the links
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['feedback/view', 'id' => $this->id], true)
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ('create' == $this->scenario) {
            $this->sendEmails();
        }

        return parent::afterSave($insert, $changedAttributes);
    }

    private function sendEmails()
    {
        $emails = Yii::$app->keyStorage->get('frontend_feedback_form_emals');
        $emails = explode(',', $emails);

        foreach ($emails as $value) {
            Yii::$app->mailer->compose('feedback_request', ['nick' => $this->nick, 'email' => $this->email, 'message' => $this->message])
                ->setSubject(Yii::t('frontend', '{app-name} | Feedback request from', [
                        'app-name' => Yii::$app->name
                ]))
                ->setTo($value)
                ->send();
        }
    }

    public function scenarios()
    {
        $scenarios           = parent::scenarios();
        $scenarios['create'] = $scenarios['default'];

        return $scenarios;
    }
}