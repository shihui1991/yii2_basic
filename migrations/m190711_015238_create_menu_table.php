<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%menu}}`.
 */
class m190711_015238_create_menu_table extends Migration
{
    protected $table = '{{%menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('上级ID'),
            'parents_ids' => $this->string()->null()->comment('所有上级ID集合'),
            'name' => $this->string()->notNull()->comment('名称'),
            'uri' => $this->string()->null()->comment('URI'),
            'router' => $this->string()->null()->comment('路由名称'),
            'icon' => $this->string()->null()->comment('图标'),
            'is_ctrl' => $this->tinyInteger(1)->unsigned()->notNull()->comment('是否限制'),
            'is_show' => $this->tinyInteger(1)->unsigned()->notNull()->comment('是否显示'),
            'status' => $this->tinyInteger(1)->unsigned()->notNull()->comment('状态'),
            'sort' => $this->integer()->unsigned()->notNull()->defaultValue(0)->comment('排序'),
            'created_at' => $this->integer(11)->unsigned()->null()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->null()->comment('更新时间'),
        ]);

        $this->addCommentOnTable($this->table,'菜单');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
