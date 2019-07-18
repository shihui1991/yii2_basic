<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m190711_022933_create_role_table extends Migration
{
    protected $table = '{{%role}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'parent_id' => $this->integer()->notNull()->unsigned()->defaultValue(0)->comment('上级ID'),
            'parents_ids' => $this->string()->null()->comment('所有上级ID集合'),
            'name' => $this->string()->notNull()->unique()->comment('名称'),
            'is_root' => $this->tinyInteger(1)->unsigned()->notNull()->comment('是否超管'),
            'created_at' => $this->integer(11)->unsigned()->null()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->null()->comment('更新时间'),
        ]);

        $this->addCommentOnTable($this->table,'角色');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
