<?php

namespace app\models;

use app\helpers\StrHelper;
use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property int $parent_id 上级ID
 * @property string $parents_ids 所有上级ID集合
 * @property string $name 名称
 * @property string $uri URI
 * @property string $router 路由名称
 * @property string $icon 图标
 * @property int $is_ctrl 是否限制
 * @property int $is_show 是否显示
 * @property int $status 状态
 * @property int $sort 排序
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Menu extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    static public function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => '上级ID',
            'parents_ids' => '所有上级ID集合',
            'name' => '名称',
            'uri' => 'URI',
            'router' => '路由名称',
            'icon' => '图标',
            'is_ctrl' => '是否限制',
            'is_show' => '是否显示',
            'status' => '状态',
            'sort' => '排序',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = [
            [['parent_id', 'name', 'uri', 'router', 'icon', 'is_ctrl', 'is_show', 'status'], 'trim'],
            [['parent_id', 'is_ctrl', 'is_show', 'status'], 'filter', 'filter' => 'intval'],
            [['parent_id', 'sort'], 'integer', 'min' => 0, 'max' => 10**10-1],
            [['name', 'is_ctrl', 'is_show', 'status'], 'required'],
            [['name', 'uri', 'router', 'icon'], 'string', 'max' => 255],
            ['is_ctrl', 'in', 'range' => array_keys(static::getValueDesc('is_ctrl'))],
            ['is_show', 'in', 'range' => array_keys(static::getValueDesc('is_show'))],
            ['status', 'in', 'range' => array_keys(static::getValueDesc('status'))],
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
            static::SCENARIO_ADD => ['parent_id', 'parents_ids', 'name', 'uri', 'router', 'icon', 'is_ctrl', 'is_show', 'status'],
            static::SCENARIO_EDIT => ['parent_id', 'parents_ids', 'name', 'uri', 'router', 'icon', 'is_ctrl', 'is_show', 'status'],
        ];

        return array_merge($scenarios, parent::scenarios());
    }

    # is_ctrl
    const IS_CTRL_NO = 0;
    const IS_CTRL_YES = 1;
    # is_show
    const IS_SHOW_NO = 0;
    const IS_SHOW_YES = 1;
    # status
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    /**
     * 数值描述
     *
     * @return array
     */
    static public function valuesDesc()
    {
        return [
            'is_ctrl' => [
                static::IS_CTRL_YES => '限制',
                static::IS_CTRL_NO => '不限',
            ],
            'is_show' => [
                static::IS_SHOW_NO => '隐藏',
                static::IS_SHOW_YES => '显示',
            ],
            'status' => [
                static::STATUS_ON => '开启',
                static::STATUS_OFF => '禁用',
            ],
        ];
    }

    /**
     * 处理 parents_ids
     *
     * @return $this
     */
    public function setParentsIds()
    {
        if($this->parent_id){
            $parent = $this->findOne($this->parent_id);
            $parentsIds = $parent->getParentsIds();
            $parentsIds[] = $this->parent_id;
            $parentsIds = array_filter($parentsIds);
        }else{
            $parentsIds = [];
        }

        $this->parents_ids = implode(',', $parentsIds);

        return $this;
    }

    /**
     * 处理 parents_ids
     *
     * @return array
     */
    public function getParentsIds()
    {
        $val = $this->parents_ids;
        if(is_string($val)){
            $val = explode(',', $val);
        }

        return  empty($val) ? [] : $val;
    }
}
