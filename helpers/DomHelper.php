<?php
namespace app\helpers;


class DomHelper
{

    /**
     * 获取普通表单字段
     *
     * @param $model
     * @param $field
     * @param string $method
     * @param null $value
     * @param array $params
     * @param array $others
     * @return mixed
     */
    static public function getFormField($model, $field, $method = 'formInput', $value = null, $params = [], $others = [])
    {
        $label = $model->getAttributeLabel($field);
        $value = property_exists($model, $field) ? $model->$field : $value;
        $valsDesc = isset($params['valsDesc']) ? $params['valsDesc'] : $model->getValueDesc($field);
        unset($params['valsDesc']);
        if( ! isset($params['name'])){
            $params['name'] = $model->formName().'['.$field.']';
            if(isset($params['multiple']) || 'formCheckbox' == $method){
                $params['name'] .= '[]';
            }
        }
        if($model->hasErrors($field)){
            $others['error'] = $model->getFirstError($field);
        }

        switch ($method){
            case 'formRadio':
            case 'formCheckbox':
            case 'formSimpleSelect':
                return AceHelper::$method($label, $field, $valsDesc, $value, $params, $others);
                break;
            case 'formSelect':
                $options = $params['options'];
                unset($params['options']);
                return AceHelper::$method($label, $field, $options, $params, $others);
                break;
            case 'formDate':
            case 'formTextarea':
                return AceHelper::$method($label, $field, $value, $params, $others);
                break;
            default:
                $type = isset($params['type']) ? $params['type'] : 'text';
                unset($params['type']);
                return AceHelper::$method($label, $field, $value, $type, $params, $others);

        }
    }
}