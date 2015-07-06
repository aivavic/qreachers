<?php

use yii\db\Schema;
use yii\db\Migration;

class m150522_094020_project extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%project_category}}', [
            'id'         => Schema::TYPE_PK,
            'slug'       => Schema::TYPE_STRING . '(1024) NOT NULL',
            'title'      => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'       => Schema::TYPE_TEXT,
            'parent_id'  => Schema::TYPE_INTEGER,
            'status'     => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'weight'     => Schema::TYPE_SMALLINT . ' NULL',
            ], $tableOptions);

        $this->createTable('{{%project}}', [
            'id'           => Schema::TYPE_PK,
            'slug'         => Schema::TYPE_STRING . '(1024) NOT NULL',
            'title'        => Schema::TYPE_STRING . '(512) NOT NULL',
            'body'         => Schema::TYPE_TEXT . ' NOT NULL',
            'category_id'  => Schema::TYPE_INTEGER,
            'author_id'    => Schema::TYPE_INTEGER,
            'updater_id'   => Schema::TYPE_INTEGER,
            'status'       => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0',
            'published_at' => Schema::TYPE_INTEGER,
            'created_at'   => Schema::TYPE_INTEGER,
            'updated_at'   => Schema::TYPE_INTEGER,
            'weight'       => Schema::TYPE_SMALLINT . ' NULL',
            ], $tableOptions);

        $this->insert('{{%project_category}}', [
            'id'         => 1,
            'slug'       => 'interview',
            'title'      => 'Interview',
            'status'     => \common\models\ProjectCategory::STATUS_ACTIVE,
            'created_at' => time()
        ]);

        $this->createIndex('idx_project_author_id', '{{%project}}', 'author_id');
        $this->addForeignKey('fk_project_author', '{{%project}}', 'author_id', '{{%user}}', 'id', 'cascade', 'cascade');

        $this->createIndex('idx_project_updater_id', '{{%project}}', 'updater_id');
        $this->addForeignKey('fk_project_updater', '{{%project}}', 'updater_id', '{{%user}}', 'id', 'set null', 'cascade');

        $this->createIndex('idx_category_id', '{{%project}}', 'category_id');
        $this->addForeignKey('fk_project_category', '{{%project}}', 'category_id', '{{%project_category}}', 'id');

        $this->createIndex('idx_parent_id', '{{%project_category}}', 'parent_id');
        $this->addForeignKey('fk_project_category_section', '{{%project_category}}', 'parent_id', '{{%project_category}}', 'id', 'cascade', 'cascade');

        $this->createTable('{{%project_attachment}}', [
            'id'         => Schema::TYPE_PK,
            'project_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'path'       => Schema::TYPE_STRING . ' NOT NULL',
            'base_url'   => Schema::TYPE_STRING,
            'type'       => Schema::TYPE_STRING,
            'size'       => Schema::TYPE_INTEGER,
            'name'       => Schema::TYPE_STRING,
            'created_at' => Schema::TYPE_INTEGER
        ]);
        $this->addForeignKey(
            'fk_project_attachment_project', '{{%project_attachment}}', 'project_id', '{{%project}}', 'id', 'cascade', 'cascade'
        );

        $this->addColumn('{{%project}}', 'thumbnail_base_url', Schema::TYPE_STRING . '(1024)');
        $this->addColumn('{{%project}}', 'thumbnail_path', Schema::TYPE_STRING . '(1024)');
    }

    public function down()
    {
        $this->dropForeignKey('fk_project_author', '{{%project}}');
        $this->dropForeignKey('fk_project_updater', '{{%project}}');
        $this->dropForeignKey('fk_project_category', '{{%project}}');
        $this->dropForeignKey('fk_project_category_section', '{{%project_category}}');

        $this->dropTable('{{%project}}');
        $this->dropTable('{{%project_category}}');

        $this->dropForeignKey(
            'fk_project_attachment_project', '{{%project_attachment}}'
        );

        $this->dropTable('{{%project_attachment}}');

        $this->dropColumn('{{%project}}', 'thumbnail_base_url');
        $this->dropColumn('{{%project}}', 'thumbnail_path');
    }
}