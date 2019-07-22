<?php

namespace app\models;

use app\helpers\ArrHelper;
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
     * query
     *
     * @return \app\queries\MenuQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \app\queries\MenuQuery(get_called_class());
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
            'uri' => [
                'attribute' => 'uri',
                'label' => 'URI',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'router' => [
                'attribute' => 'router',
                'label' => '路由',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'icon' => [
                'attribute' => 'icon',
                'label' => '图标',
                'format' => 'raw',
                'jsonFormat' => 'string',
            ],
            'is_ctrl' => [
                'attribute' => 'is_ctrl',
                'label' => '是否限制',
                'format' => 'text',
                'jsonFormat' => 'int',
                'value' => function($model,$widget){return $model->getValueDesc('is_ctrl',$model->is_ctrl);},
            ],
            'is_show' => [
                'attribute' => 'is_show',
                'label' => '是否显示',
                'format' => 'text',
                'jsonFormat' => 'int',
                'value' => function($model,$widget){return $model->getValueDesc('is_show',$model->is_show);},
            ],
            'status' => [
                'attribute' => 'status',
                'label' => '状态',
                'format' => 'text',
                'jsonFormat' => 'int',
                'value' => function($model,$widget){return $model->getValueDesc('status',$model->status);},
            ],
            'sort' => [
                'attribute' => 'sort',
                'label' => '排序',
                'format' => 'integer',
                'jsonFormat' => 'int',
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
            static::SCENARIO_ADD => ['parent_id', 'parents_ids', 'name', 'uri', 'router', 'icon', 'is_ctrl', 'is_show', 'status', 'sort'],
            static::SCENARIO_EDIT => ['parent_id', 'parents_ids', 'name', 'uri', 'router', 'icon', 'is_ctrl', 'is_show', 'status', 'sort'],
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
     * @return array|\yii\db\ActiveRecord[]|null
     */
    public function getParentsMenus()
    {
        return $this->parent_id ? $this->find()->where(['id' => $this->formatValForParentsIds()])->all() : null;
    }
}
