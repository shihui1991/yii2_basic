<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = '修改角色';

?>

<div class="well">
    <a href="<?= Url::toRoute('index')?>" class="btn btn-default"><i class="ace-icon fa fa-arrow-left"></i>返回列表</a>
    <a href="<?= Url::toRoute(['create','parent_id' => $model->id])?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加下级</a>
    <a href="<?= Url::toRoute(['view','id' => $model->id])?>" class="btn btn-primary"><i class="ace-icon fa fa-info-circle"></i>详情</a>
    <a class="btn btn-danger" onclick="btnFormAjaxRequest(this)" data-msg="是否确定删除吗？" data-url="<?= Url::toRoute(['delete','id' => $model->id]) ?>" data-type="DELETE"><i class="ace-icon fa fa-trash"></i>删除</a>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
