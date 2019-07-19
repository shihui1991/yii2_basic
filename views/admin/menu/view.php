<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */

$this->title = '菜单详情';

?>

<div class="well">
    <a href="<?= Url::toRoute('index')?>" class="btn btn-default"><i class="ace-icon fa fa-arrow-left"></i>返回列表</a>
    <a href="<?= Url::toRoute(['create','parent_id' => $model->id])?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加下级</a>
    <a href="<?= Url::toRoute(['update','id' => $model->id])?>" class="btn btn-primary"><i class="ace-icon fa fa-edit"></i>修改</a>
    <a class="btn btn-danger" onclick="btnFormAjaxRequest(this)" data-msg="是否确定删除吗？" data-form="#batch-action-form" data-url="<?= Url::toRoute(['delete','id' => $model->id]) ?>" data-type="DELETE"><i class="ace-icon fa fa-trash"></i>删除</a>
</div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => $model->fieldsInfo(),
])?>
