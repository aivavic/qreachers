<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_064950_member extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%member_category}}', [
            'id'         => Schema::TYPE_PK,
            'slug'       => Schema::TYPE_STRING . '(1024) NOT NULL',
            'title'      => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'       => Schema::TYPE_TEXT,
            'parent_id'  => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%member}}', [
            'id'           => Schema::TYPE_PK,
            'slug'         => Schema::TYPE_STRING . '(1024) NOT NULL',
            'firstname' => Schema::TYPE_STRING . '(255) ',
            'middlename' => Schema::TYPE_STRING . '(255) ',
            'lastname' => Schema::TYPE_STRING . '(255) ',
            'position' => Schema::TYPE_STRING . '(255) ',
            'locale' => Schema::TYPE_STRING . '(32)',
            'gender' => Schema::TYPE_INTEGER . '(1)',
            'video' => Schema::TYPE_STRING . '(255) ',
            'status_home'       => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',

            'title'        => Schema::TYPE_STRING . '(512) NOT NULL',
            'description'  => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'         => Schema::TYPE_TEXT . ' NOT NULL',
            'category_id'  => Schema::TYPE_INTEGER,
            'author_id'    => Schema::TYPE_INTEGER,
            'updater_id'   => Schema::TYPE_INTEGER,
            'status'       => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'published_at' => Schema::TYPE_INTEGER,
            'created_at'   => Schema::TYPE_INTEGER,
            'updated_at'   => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->insert('{{%member_category}}', [
            'id'         => 1,
            'slug'       => 'news',
            'title'      => 'News',
            'status'     => 1,
            'created_at' => time()
        ]);

        $this->createIndex('idx_member_author_id', '{{%member}}', 'author_id');
        $this->addForeignKey('fk_member_author', '{{%member}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createIndex('idx_member_updater_id', '{{%member}}', 'updater_id');
        $this->addForeignKey('fk_member_updater', '{{%member}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');

        $this->createIndex('idx_category_id', '{{%member}}', 'category_id');
        $this->addForeignKey('fk_member_category', '{{%member}}', 'category_id', '{{%member_category}}', 'id');

        $this->createIndex('idx_parent_id', '{{%member_category}}', 'parent_id');
        $this->addForeignKey('fk_member_category_section', '{{%member_category}}', 'parent_id', '{{%member_category}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%member_attachment}}', [
            'id'         => Schema::TYPE_PK,
            'member_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'path'       => Schema::TYPE_STRING . ' NOT NULL',
            'base_url'   => Schema::TYPE_STRING,
            'type'       => Schema::TYPE_STRING,
            'size'       => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
            'fk_member_attachment_member', '{{%member_attachment}}', 'member_id', '{{%member}}', 'id', 'cascade', 'cascade'
        );

        $this->addColumn('{{%member}}', 'thumbnail_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%member}}', 'thumbnail_path', Schema::TYPE_STRING . '(1024)');

        $this->addColumn('{{%member}}', 'head', Schema::TYPE_TEXT . ' NOT NULL');

        $this->addColumn('{{%member}}', 'weight', Schema::TYPE_SMALLINT . ' NULL');
        $this->addColumn('{{%member_category}}', 'weight', Schema::TYPE_SMALLINT . ' NULL');
    }

    public function down()
    {
        echo "m150618_064950_member cannot be reverted.\n";

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