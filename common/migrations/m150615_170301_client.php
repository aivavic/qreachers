<?php

use yii\db\Schema;
use yii\db\Migration;

class m150615_170301_client extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%client_category}}', [
            'id'         => Schema::TYPE_PK,
            'slug'       => Schema::TYPE_STRING . '(1024) NOT NULL',
            'title'      => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'       => Schema::TYPE_TEXT,
            'parent_id'  => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            ], $tableOptions);

        $this->createTable('{{%client}}', [
            'id'           => Schema::TYPE_PK,
            'slug'         => Schema::TYPE_STRING . '(1024) NOT NULL',
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

        $this->insert('{{%client_category}}', [
            'id'         => 1,
            'slug'       => 'news',
            'title'      => 'News',
            'status'     => 1,
            'created_at' => time()
        ]);

        $this->createIndex('idx_client_author_id', '{{%client}}', 'author_id');
        $this->addForeignKey('fk_client_author', '{{%client}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createIndex('idx_client_updater_id', '{{%client}}', 'updater_id');
        $this->addForeignKey('fk_client_updater', '{{%client}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');

        $this->createIndex('idx_category_id', '{{%client}}', 'category_id');
        $this->addForeignKey('fk_client_category', '{{%client}}', 'category_id', '{{%client_category}}', 'id');

        $this->createIndex('idx_parent_id', '{{%client_category}}', 'parent_id');
        $this->addForeignKey('fk_client_category_section', '{{%client_category}}', 'parent_id', '{{%client_category}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%client_attachment}}', [
            'id'         => Schema::TYPE_PK,
            'client_id'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'path'       => Schema::TYPE_STRING . ' NOT NULL',
            'base_url'   => Schema::TYPE_STRING,
            'type'       => Schema::TYPE_STRING,
            'size'       => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
            'fk_client_attachment_client', '{{%client_attachment}}', 'client_id', '{{%client}}', 'id', 'cascade', 'cascade'
        );

        $this->addColumn('{{%client}}', 'thumbnail_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%client}}', 'thumbnail_path', Schema::TYPE_STRING . '(1024)');

        $this->addColumn('{{%client}}', 'head', Schema::TYPE_TEXT . ' NOT NULL');

        $this->addColumn('{{%client}}','weight',Schema::TYPE_SMALLINT . ' NULL');
        $this->addColumn('{{%client_category}}','weight',Schema::TYPE_SMALLINT . ' NULL');
    }

    public function down()
    {
        echo "m150615_170301_client cannot be reverted.\n";

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