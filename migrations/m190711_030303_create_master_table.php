<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%master}}`.
 */
class m190711_030303_create_master_table extends Migration
{
    protected $table = '{{%master}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey()->unsigned(),
            'name' => $this->string()->notNull()->comment('姓名'),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'password' => $this->string()->notNull()->comment('密码'),
            'status' => $this->tinyInteger(1)->unsigned()->notNull()->comment('状态'),
            'created_at' => $this->integer(11)->unsigned()->null()->comment('创建时间'),
            'updated_at' => $this->integer(11)->unsigned()->null()->comment('更新时间'),
        ]);

        $this->addCommentOnTable($this->table,'用户');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
