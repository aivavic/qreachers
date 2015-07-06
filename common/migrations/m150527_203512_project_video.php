<?php

use yii\db\Schema;
use yii\db\Migration;

class m150527_203512_project_video extends Migration
{
    public function up()
    {
        $this->addColumn('{{%project}}', 'video_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%project}}', 'video_path', Schema::TYPE_STRING . '(1024)');
    }

    public function down()
    {
        echo "m150527_203512_project_video cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
