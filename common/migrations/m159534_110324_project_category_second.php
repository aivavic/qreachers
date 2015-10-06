<?php

use yii\db\Schema;
use yii\db\Migration;

class m159534_110324_project_category_second extends Migration
{

    public function up()
    {
        $this->addColumn('{{%project_category_second}}', 'locale', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150544_010724_project_category_second cannot be reverted.\n";

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