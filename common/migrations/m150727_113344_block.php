<?php

use yii\db\Schema;
use yii\db\Migration;

class m150727_113344_block extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%block}}', [
            'id'              => Schema::TYPE_PK,
            'slug'            => Schema::TYPE_STRING . '(1024)',
            'title'           => Schema::TYPE_STRING . '(1024)',
            'description'     => Schema::TYPE_STRING . '(1024)',
            'locale'          => Schema::TYPE_STRING . '(512) NOT NULL DEFAULT "ru-RU"',
            'locale_group_id' => Schema::TYPE_INTEGER,
            'body'            => Schema::TYPE_TEXT . ' NOT NULL',
            'status'          => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'domain'          => Schema::TYPE_STRING
            ], $tableOptions);
    }

    public function down()
    {
        echo "m150727_113344_block cannot be reverted.\n";

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