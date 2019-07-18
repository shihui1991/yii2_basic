<?php

use yii\db\Migration;

/**
 * Class m190711_034430_create_junction_user_and_role
 */
class m190711_034430_create_junction_user_and_role extends Migration
{
    protected $table = '{{%user_role}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'user_id' => $this->integer()->unsigned()->notNull()->comment('用户ID'),
            'role_id' => $this->integer()->unsigned()->notNull()->comment('角色ID'),
        ]);

        $this->createIndex('userId_roleId_unique',$this->table,['user_id','role_id'],true);

        $this->addCommentOnTable($this->table,'用户角色');
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
        echo "m190711_034430_create_junction_user_and_role cannot be reverted.\n";

        return false;
    }
    */
}
