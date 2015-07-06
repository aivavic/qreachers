<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_065219_weight extends Migration
{
    public function up()
    {
          $this->addColumn('{{%article}}','weight',Schema::TYPE_SMALLINT . ' NULL');
          $this->addColumn('{{%article_category}}','weight',Schema::TYPE_SMALLINT . ' NULL');
    }

    public function down()
    {
        echo "m150519_065219_weight cannot be reverted.\n";

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
