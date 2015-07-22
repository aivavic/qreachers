<?php

use yii\db\Schema;
use yii\db\Migration;

class m150722_061803_feedback extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%feedback_category}}', [
            'id'         => Schema::TYPE_PK,
            'slug'       => Schema::TYPE_STRING . '(1024) NOT NULL',
            'title'      => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'       => Schema::TYPE_TEXT,
            'parent_id'  => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%feedback}}', [
            'id'           => Schema::TYPE_PK,
            'slug'         => Schema::TYPE_STRING . '(1024)',
            'title'        => Schema::TYPE_STRING . '(512)',
            'description'  => Schema::TYPE_STRING . '(512)',
            'nick'         => Schema::TYPE_STRING . '(512)',
            'email'        => Schema::TYPE_STRING . '(512)',
            'message'      => Schema::TYPE_TEXT,
            'body'         => Schema::TYPE_TEXT ,
            'category_id'  => Schema::TYPE_INTEGER,
            'author_id'    => Schema::TYPE_INTEGER,
            'updater_id'   => Schema::TYPE_INTEGER,
            'status'       => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'published_at' => Schema::TYPE_INTEGER,
            'created_at'   => Schema::TYPE_INTEGER,
            'updated_at'   => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->insert('{{%feedback_category}}', [
            'id'         => 1,
            'slug'       => 'news',
            'title'      => 'News',
            'status'     => 1,
            'created_at' => time()
        ]);

        $this->createIndex('idx_feedback_author_id', '{{%feedback}}', 'author_id');
        $this->addForeignKey('fk_feedback_author', '{{%feedback}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createIndex('idx_feedback_updater_id', '{{%feedback}}', 'updater_id');
        $this->addForeignKey('fk_feedback_updater', '{{%feedback}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');

        $this->createIndex('idx_category_id', '{{%feedback}}', 'category_id');
        $this->addForeignKey('fk_feedback_category', '{{%feedback}}', 'category_id', '{{%feedback_category}}', 'id');

        $this->createIndex('idx_parent_id', '{{%feedback_category}}', 'parent_id');
        $this->addForeignKey('fk_feedback_category_section', '{{%feedback_category}}', 'parent_id', '{{%feedback_category}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%feedback_attachment}}', [
            'id'         => Schema::TYPE_PK,
            'feedback_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'path'       => Schema::TYPE_STRING . ' NOT NULL',
            'base_url'   => Schema::TYPE_STRING,
            'type'       => Schema::TYPE_STRING,
            'size'       => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
            'fk_feedback_attachment_feedback', '{{%feedback_attachment}}', 'feedback_id', '{{%feedback}}', 'id', 'cascade', 'cascade'
        );

        $this->addColumn('{{%feedback}}', 'thumbnail_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%feedback}}', 'thumbnail_path', Schema::TYPE_STRING . '(1024)');

        $this->addColumn('{{%feedback}}', 'head', Schema::TYPE_TEXT);

        $this->addColumn('{{%feedback}}', 'weight', Schema::TYPE_SMALLINT . ' NULL');
        $this->addColumn('{{%feedback_category}}', 'weight', Schema::TYPE_SMALLINT . ' NULL');

        $this->addColumn('{{%feedback}}', 'domain', Schema::TYPE_STRING);
        $this->addColumn('{{%feedback}}', 'lang', Schema::TYPE_STRING . '(50)');
    }

    public function down()
    {
        echo "m150722_061803_contact_us_form cannot be reverted.\n";

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