<?php

namespace app\models;

use app\helpers\ArrHelper;

/**
 * This is the model class for table "MasterRole".
 *
 * @property int $role_id
 * @property int $master_id
 */
class MasterRole extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    static public function tableName()
    {
        return 'master_role';
    }

    /**
     * query
     *
     * @return \app\queries\MasterRoleQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \app\queries\MasterRoleQuery(get_called_class());
    }


    /**
     * 字段信息
     *
     * @return array
     */
    public function fieldsInfo()
    {
        return [
            'master_id' => [
                'attribute' => 'master_id',
                'label' => '用户ID',
                'format' => 'integer',
                'jsonFormat' => 'int',
            ],
            'role_id' => [
                'attribute' => 'role_id',
                'label' => '角色ID',
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
            [['role_id', 'master_id'], 'trim'],
            [['role_id', 'master_id'], 'filter', 'filter' => 'intval'],
            [['role_id', 'master_id'], 'integer', 'min' => 0, 'max' => 10**10-1],
            [['role_id', 'master_id'], 'required'],
            [['role_id', 'master_id'], 'unique', 'targetAttribute' => ['role_id', 'master_id']],
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
            static::SCENARIO_ADD => ['role_id', 'master_id'],
        ];

        return array_merge($scenarios, parent::scenarios());
    }

    /**
     * 批量创建
     *
     * @param $masterId
     * @param $roleIds
     * @return int
     * @throws \yii\db\Exception
     */
    public function batchCreate($masterId, $roleIds)
    {
        $list = [];
        foreach($roleIds as $roleId){
            $list[] = [
                'master_id' => $masterId,
                'role_id' => $roleId,
            ];
        }
        return $this->batchInsertOrUpdate($list);
    }
}
