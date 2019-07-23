<?php

namespace app\models;

use app\helpers\ArrHelper;

/**
 * This is the model class for table "role".
 *
 * @property int $role_id
 * @property int $menu_id
 */
class RoleMenu extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    static public function tableName()
    {
        return 'role_menu';
    }

    /**
     * query
     *
     * @return \app\queries\RoleMenuQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \app\queries\RoleMenuQuery(get_called_class());
    }


    /**
     * 字段信息
     *
     * @return array
     */
    public function fieldsInfo()
    {
        return [
            'role_id' => [
                'attribute' => 'role_id',
                'label' => '角色ID',
                'format' => 'integer',
                'jsonFormat' => 'int',
            ],
            'menu_id' => [
                'attribute' => 'menu_id',
                'label' => '菜单ID',
                'format' => 'integer',
                'jsonFormat' => 'int',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['role_id', 'menu_id'], 'trim'],
            [['role_id', 'menu_id'], 'filter', 'filter' => 'intval'],
            [['role_id', 'menu_id'], 'integer', 'min' => 0, 'max' => 10**10-1],
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id'], 'unique', 'targetAttribute' => ['role_id', 'menu_id']],
        ];

        return array_merge($rules, parent::rules());
    }

    const SCENARIO_ADD = 'add';

    /**
     * 场景
     *
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            static::SCENARIO_ADD => ['role_id', 'menu_id'],
        ];

        return array_merge($scenarios, parent::scenarios());
    }

    /**
     * 获取上级
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::className(),['id' => 'parent_id']);
    }

    /**
     * 获取所有直属下级列表
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(static::className(),['parent_id' => 'id']);
    }

    /**
     * 批量创建
     *
     * @param $roleId
     * @param $menuIds
     * @return int
     * @throws \yii\db\Exception
     */
    public function batchCreate($roleId, $menuIds)
    {
        $list = [];
        foreach($menuIds as $menuId){
            $list[] = [
                'role_id' => $roleId,
                'menu_id' => $menuId,
            ];
        }
        return $this->batchInsertOrUpdate($list);
    }
}
