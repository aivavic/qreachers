<?php

use yii\db\Schema;
use yii\db\Migration;

class m150701_155534_multi_category extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%article_categories}}', [
            'id'         => Schema::TYPE_PK,
            'article_id'       => Schema::TYPE_INTEGER,
            'category_id'       => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%project_categories}}', [
            'id'         => Schema::TYPE_PK,
            'project_id'       => Schema::TYPE_INTEGER,
            'category_id'       => Schema::TYPE_INTEGER,            
            ], $tableOptions);
    }

    public function down()
    {
        echo "m150701_155534_multi_category cannot be reverted.\n";

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