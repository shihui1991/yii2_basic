<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Master */

$this->title = '用户详情';

$formatter = \Yii::$app->formatter;
?>

<div class="well">
    <a href="<?= Url::toRoute('index')?>" class="btn btn-default"><i class="ace-icon fa fa-arrow-left"></i>返回列表</a>
    <a href="<?= Url::toRoute(['create'])?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加用户</a>
    <a href="<?= Url::toRoute(['update','id' => $model->id])?>" class="btn btn-primary"><i class="ace-icon fa fa-edit"></i>修改</a>
    <a class="btn btn-danger" onclick="btnFormAjaxRequest(this)" data-msg="是否确定删除吗？" data-url="<?= Url::toRoute(['delete','id' => $model->id]) ?>" data-type="DELETE"><i class="ace-icon fa fa-trash"></i>删除</a>
</div>

<table id="w0" class="table table-striped table-bordered detail-view">
    <?php foreach($model->fieldsInfo() as $field => $info): ?>
        <?php $method = 'as'.ucfirst($info['format']); ?>

    <tr>
        <th><?= $info['label'] ?></th>
        <td><?= $formatter->$method($model->getValueDesc($field,$model->$field)) ?></td>
    </tr>
    <?php endforeach;?>

    <tr>
        <th>角色</th>
        <td>
            <?php foreach($model->roles as $role): ?>
            <?= $role->name ?> &nbsp;
            <?php endforeach;?>
        </td>
    </tr>
</table>
