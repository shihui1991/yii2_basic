<?php

namespace app\models;

use app\helpers\ArrHelper;
use Yii;

/**
 * This is the model class for table "master".
 *
 * @property int $id
 * @property string $name 姓名
 * @property string $username 用户名
 * @property string $password 密码
 * @property int $status 状态
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Master extends ModelBase
{
    /**
     * {@inheritdoc}
     */
    static public function tableName()
    {
        return 'master';
    }

    /**
     * query
     *
     * @return \app\queries\MasterQuery|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new \app\queries\MasterQuery(get_called_class());
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
            'name' => [
                'attribute' => 'name',
                'label' => '姓名',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'username' => [
                'attribute' => 'username',
                'label' => '用户名',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'password' => [
                'attribute' => 'password',
                'label' => '密码',
                'format' => 'text',
                'jsonFormat' => 'string',
            ],
            'status' => [
                'attribute' => 'status',
                'label' => '状态',
                'format' => 'raw',
                'jsonFormat' => 'int',
                'value' => function($model,$widget){return $model->getValueDesc('status',$model->status);},
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
            [['name', 'username', 'password', 'status'], 'trim'],
            [['status'], 'filter', 'filter' => 'intval'],
            [['name', 'username', 'password', 'status'], 'required'],
            [['name'], 'string', 'min' => 2, 'max' => 255],
            [['username'], 'string', 'min' => 3, 'max' => 255],
            [['username'], 'unique', 'on' => [static::SCENARIO_ADD,static::SCENARIO_EDIT]],
            [['password'], 'string', 'min' => 6, 'max' => 255],
            ['status', 'in', 'range' => array_keys(static::getValueDesc('status'))],
        ];

        return array_merge($rules, parent::rules());
    }

    const SCENARIO_LIST = 'list';
    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';
    const SCENARIO_LOGIN = 'login';
    const SCENARIO_PROFILE = 'profile';
    const SCENARIO_PASSWORD = 'password';

    /**
     * 场景
     *
     * @return array
     */
    public function scenarios()
    {
        $scenarios = [
            static::SCENARIO_LIST => ['id', 'name', 'username', 'status'],
            static::SCENARIO_ADD => ['name', 'username', 'password', 'status'],
            static::SCENARIO_EDIT => ['name', 'username', 'password', 'status'],
            static::SCENARIO_LOGIN => ['username', 'password'],
            static::SCENARIO_PROFILE => ['name', 'username'],
            static::SCENARIO_PASSWORD => ['password'],
        ];

        return array_merge($scenarios, parent::scenarios());
    }

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
            'status' => [
                static::STATUS_ON => '启用',
                static::STATUS_OFF => '禁用',
            ],
        ];
    }
    
    /**
     * 获取所有角色
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMasterRoles()
    {
        return $this->hasMany(MasterRole::className(),['master_id' => 'id']);
    }

    /**
     * 获取所有角色ID列表
     *
     * @return array
     */
    public function getRolesIds()
    {
        if($masterRoles = $this->masterRoles){
            $roleIds = [];
            foreach($masterRoles as $row){
                $roleIds[] = $row->role_id;
            }
            return $roleIds;
        }

        return [];
    }

    /**
     * 获取所有角色列表
     *
     * @return \yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public function getRoles()
    {
        return $this->hasMany(Role::className(),['id' => 'role_id'])->viaTable('master_role',['master_id' => 'id']);
    }

    /**
     * 验证是不是超级管理员
     *
     * @return bool
     */
    public function isRoot()
    {
        $roles = $this->roles;
        if(empty($roles)){
            return false;
        }
        foreach($roles as $role){
            if(Role::IS_ROOT_YES == $role->is_root){
                return true;
            }
        }
        return false;
    }

    /**
     * 获取所有授权的菜单ID
     *
     * @return array
     */
    public function getAuthMenuIds()
    {
        $roleIds = $this->getRolesIds();
        if(empty($roleIds)){
            return [];
        }
        $roleMenus = RoleMenu::findAll(['in','role_id',$roleIds]);
        $menuIds = [];
        foreach($roleMenus as $roleMenu){
            $menuIds[] = $roleMenu->menu_id;
        }

        return array_unique($menuIds);
    }

    /**
     * 处理 password
     */
    public function setValForPassword()
    {
        $info = password_get_info($this->password);
        if ($this->password && (0 == $info['algo'] || 'unknown' == $info['algoName'])) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
    }

    /**
     * 登录
     *
     * @return bool
     */
    public function login()
    {
        $this->setScenario(static::SCENARIO_LOGIN);
        $this->load(Yii::$app->request->post());
        $res = $this->validate();
        if( ! $res){
            $errors = $this->getFirstErrors();
            Yii::$app->session->addFlash('error',array_shift($errors));
            return false;
        }
        $master = $this->findOne(['username' => $this->username]);
        if( ! $master){
            Yii::$app->session->addFlash('error','用户不存在');
            return false;
        }
        if( ! password_verify($this->password,$master->password)){
            Yii::$app->session->addFlash('error','密码错误');
            return false;
        }
        if(static::STATUS_OFF == $master->status){
            Yii::$app->session->addFlash('error','用户已禁用');
            return false;
        }
        $isRoot = $master->isRoot();
        $menuIds = $master->getAuthMenuIds();
        $session = [
            'master' => $master,
            'isRoot' => $isRoot,
            'menuIds' => $menuIds,
        ];
        Yii::$app->session->set('master',$session);

        return true;
    }
}
