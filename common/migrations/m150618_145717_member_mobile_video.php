<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_145717_member_mobile_video extends Migration
{
    public function up()
    {
        $this->addColumn('{{%member}}', 'video_mobile', Schema::TYPE_STRING . '(255) ');
    }


    public function down()
    {
        echo "m150618_145717_members_mobile_video cannot be reverted.\n";

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
