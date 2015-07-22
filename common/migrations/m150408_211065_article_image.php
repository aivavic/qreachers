<?php

use yii\db\Schema;
use yii\db\Migration;

class m150408_211065_article_image extends Migration
{
    public function up()
    {
        $this->addColumn('{{%article}}', 'image_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%article}}', 'image_path', Schema::TYPE_STRING . '(1024)');
    }

    public function down()
    {
        $this->dropColumn('{{%article}}', 'image_base_url');
        $this->dropColumn('{{%article}}', 'image_path');
    }
}
