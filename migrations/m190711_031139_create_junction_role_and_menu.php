<?php

use yii\db\Migration;

/**
 * Class m190711_031139_create_junction_role_and_menu
 */
class m190711_031139_create_junction_role_and_menu extends Migration
{
    protected $table = '{{%role_menu}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'role_id' => $this->integer()->unsigned()->notNull()->comment('角色ID'),
            'menu_id' => $this->integer()->unsigned()->notNull()->comment('菜单ID'),
        ]);

        $this->createIndex('roleId_menuId_unique',$this->table,['role_id','menu_id'],true);

        $this->addCommentOnTable($this->table,'角色授权菜单');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190711_031139_create_junction_role_and_menu cannot be reverted.\n";

        return false;
    }
    */
}
