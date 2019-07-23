<?php

namespace app\models;

use app\helpers\ArrHelper;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property int $parent_id 上级ID
 * @property string $parents_ids 所有上级ID集合
 * @property string $name 名称
 * @property string $is_root 是否超管
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Role extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    static public function tableName()
    {
        return 'role';
    }

    /**
     * query
     *
     * @return \app\queries\RoleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \app\queries\RoleQuery(get_called_class());
    }


    /**
     * 字段信息
     *
     * @return array
     */
    public function fieldsInfo()
    {
        return [
            'id' => [
                'attribute' => 'id',
                'label' => 'ID',
                'format' => 'integer',
                'jsonFormat' => 'int',
            ],
            'parent_id' => [
                'attribute' => 'parent_id',
                'label' => '上级ID',
                'format' => 'integer',
                'jsonFormat' => 'int',
            ],
            'parents_ids' => [
                'attribute' => 'parents_ids',
                'label' => '所有上级ID集合',
                'format' => 'raw',
                'jsonFormat' => 'array',
            ],
            'name' => [
                'attribute' => 'name',
                'label' => '名称',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'is_root' => [
                'attribute' => 'is_root',
                'label' => '是否超管',
                'format' => 'raw',
                'jsonFormat' => 'int',
                'value' => function($model,$widget){return $model->getValueDesc('is_root',$model->is_root);},
            ],
            'created_at' => [
                'attribute' => 'created_at',
                'label' => '创建时间',
                'format' => 'datetime',
                'jsonFormat' => 'timestamp',
            ],
            'updated_at' => [
                'attribute' => 'updated_at',
                'label' => '更新时间',
                'format' => 'datetime',
                'jsonFormat' => 'timestamp',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['parent_id', 'name', 'is_root'], 'trim'],
            [['parent_id', 'is_root'], 'filter', 'filter' => 'intval'],
            [['parent_id'], 'integer', 'min' => 0, 'max' => 10**10-1],
            [['name', 'is_root'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            ['is_root', 'in', 'range' => array_keys(static::getValueDesc('is_root'))],
        ];

        return array_merge($rules, parent::rules());
    }

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';

    /**
     * 场景
     *
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            static::SCENARIO_ADD => ['parent_id', 'parents_ids', 'name', 'is_root'],
            static::SCENARIO_EDIT => ['parent_id', 'parents_ids', 'name', 'is_root'],
        ];

        return array_merge($scenarios, parent::scenarios());
    }

    # is_root
    const IS_ROOT_NO = 0;
    const IS_ROOT_YES = 1;

    /**
     * 数值描述
     *
     * @return array
     */
    static public function valuesDesc()
    {
        return [
            'is_root' => [
                static::IS_ROOT_NO => '否',
                static::IS_ROOT_YES => '是',
            ],
        ];
    }

    /**
     * 处理 parents_ids
     *
     * @return $this
     */
    public function setValForParentsIds()
    {
        if($this->parent_id){
            $parent = $this->findOne($this->parent_id);
            $parentsIds = $parent->formatValForParentsIds();
            $parentsIds[] = $this->parent_id;
            $parentsIds = array_filter($parentsIds);
        }else{
            $parentsIds = [];
        }

        $this->parents_ids = implode(',', $parentsIds);

        return $this;
    }

    /**
     * 格式化 parents_ids
     *
     * @return array
     */
    public function formatValForParentsIds()
    {
        $val = $this->parents_ids;
        if($val && is_string($val)){
            $val = explode(',', $val);
        }
        $val = empty($val) ? [] : ArrHelper::formatNumeric($val,true);

        return  $val;
    }

    /**
     * 获取所有上级列表
     *
     * @return array|\yii\db\ActiveRecord[]|null
     */
    public function getParents()
    {
        return $this->parent_id ? $this->find()->where(['id' => $this->formatValForParentsIds()])->all() : null;
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
     * 获取所有授权菜单
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleMenus()
    {
        return $this->hasMany(RoleMenu::className(),['role_id' => 'id']);
    }

    /**
     * 获取所有授权菜单ID列表
     *
     * @return array
     */
    public function getMenusIds()
    {
        if($roleMenus = $this->roleMenus){
            $menuIds = [];
            foreach($roleMenus as $row){
                $menuIds[] = $row->menu_id;
            }
            return $menuIds;
        }

        return [];
    }

    /**
     * 获取所有授权菜单列表
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(),['id' => 'menu_id'])->viaTable('role_menu',['role_id' => 'id']);
    }
}
