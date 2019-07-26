<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Master;

/* @var $this yii\web\View */
/* @var $list  */

$this->title = '用户列表';

$fields = Master::instance()->getFields(Master::SCENARIO_LIST);
?>

<div class="well">
    <a href="<?= Url::toRoute('create')?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加用户</a>
</div>

<form action="" id="batch-action-form" method="post">
<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <?php foreach($fields as $field): ?>
        <th><?= Master::instance()->getAttributeLabel($field)?></th>
        <?php endforeach; ?>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php foreach($list as $row): ?>
        <tr>
            <?php foreach($fields as $field): ?>
                <td><?= $row->getValueDesc($field, $row->$field) ?></td>
            <?php endforeach; ?>
            <td>
                <div class="btn-group">
                    <a href="<?= Url::toRoute(['view','id' => $row->id])?>" class="btn btn-xs btn-info"><i class="ace-icon fa fa-info-circle"></i>详情</a>
                    <a href="<?= Url::toRoute(['update','id' => $row->id])?>" class="btn btn-xs btn-primary"><i class="ace-icon fa fa-edit"></i>修改</a>
                    <a class="btn btn-xs btn-danger" onclick="btnFormAjaxRequest(this)" data-msg="是否确定删除吗？" data-url="<?= Url::toRoute(['delete','id' => $row->id]) ?>" data-type="DELETE"><i class="ace-icon fa fa-trash"></i>删除</a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</form>

<?php $this->beginBlock('pageSpecificCss')?>

<?php $this->endBlock()?>

<?php $this->beginBlock('inlineCss')?>
<style>

</style>
<?php $this->endBlock()?>

<?php $this->beginBlock('pageSpecificJs')?>

<?php $this->endBlock()?>

<?php $this->beginBlock('inlineJs')?>
<script>

</script>
<?php $this->endBlock()?>
