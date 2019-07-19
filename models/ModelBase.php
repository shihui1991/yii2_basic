<?php

namespace app\models;


use app\helpers\StrHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class ModelBase extends ActiveRecord
{

    /**
     * 行为
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    static::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    static::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * 字段信息
     *
     * @return array
     */
    public function fieldsInfo(){return [];}

    /**
     * 字段名称
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_column(static::fieldsInfo(),'label','attribute');
    }

    /**
     * 数值描述
     *
     * @return array
     */
    static public function valuesDesc(){return [];}

    /**
     * 获取数值描述
     *
     * @param $field
     * @param null $value
     * @return mixed|null
     */
    static public function getValueDesc($field, $value = null)
    {
        $descArray = static::valuesDesc();
        if( ! isset($descArray[$field])){
            return $value;
        }
        if(is_null($value)){
            return $descArray[$field];
        }
        return isset($descArray[$field][$value]) ? $descArray[$field][$value] : $value;
    }

    /**
     * 保存编辑
     *
     * @param $scenario
     * @return bool
     */
    public function modify($scenario)
    {
        $this->setScenario($scenario);
        $this->load(Yii::$app->request->post());
        $this->handleActiveFields();
        return $this->save();
    }

    /**
     * 字段值保存前处理
     */
    public function handleActiveFields()
    {
        $fields = $this->activeAttributes();
        foreach($fields as $field){
            $method = 'setValFor'.StrHelper::camel($field);
            if(method_exists($this,$method)){
                $this->$method();
            }
        }
    }

    /**
     * 字段格式化
     */
    public function toJson()
    {
        foreach($this->fields() as $field){
            $method = 'formatValFor'.StrHelper::camel($field);
            if(method_exists($this,$method)){
                $this->$method();
            }
        }
    }
}