<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $list  */

$this->title = '角色列表';

?>

<div class="well">
    <a href="<?= Url::toRoute('create')?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加顶级角色</a>
</div>

<form action="" id="batch-action-form" method="post">
<table class="table table-hover table-bordered treetable">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="allCheckOrCancel(this)"> ID</th>
        <th>名称</th>
        <th>是否超管</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php
    $dataList = [];
    foreach($list as $i => $model){
        $dataList[$i] = $model->toArray();
        $dataList[$i]['is_root'] = $model->getValueDesc('is_root',$model->is_root);
        $dataList[$i]['url_create'] = Url::toRoute(['create','parent_id' => $model->id]);
        $dataList[$i]['url_view'] = Url::toRoute(['view','id' => $model->id]);
        $dataList[$i]['url_update'] = Url::toRoute(['update','id' => $model->id]);
        $dataList[$i]['url_delete'] = Url::toRoute(['delete','id' => $model->id]);
    }
    $tpl = "
 <tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
     <td><input type='checkbox' name='ids[]' value='\$id'> \$id</td>
     <td>\$name</td>
     <td>\$is_root</td>
     <td>
         <div class='btn-group'>
             <a href='\$url_create' class='btn btn-xs btn-success'><i class='ace-icon fa fa-plus'></i>添加下级</a>
             <a href='\$url_view' class='btn btn-xs btn-info'><i class='ace-icon fa fa-info-circle'></i>详情</a>
             <a href='\$url_update' class='btn btn-xs btn-primary'><i class='ace-icon fa fa-pencil-square-o'></i>修改</a>
             <a data-url='\$url_delete' class='btn btn-xs btn-danger' onclick='btnFormAjaxRequest(this)' data-msg='是否确定删除吗？' data-type='DELETE'><i class='ace-icon fa fa-trash-o'></i>删除</a>
         </div>
     </td>
 </tr>
";

    echo \app\helpers\HtmlHelper::makeTree($dataList,$tpl);
    ?>
    </tbody>
</table>
</form>

<?php $this->beginBlock('pageSpecificCss')?>
<link rel="stylesheet" href="/treetable/treetable.min.css">
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineCss')?>
<style>
</style>
<?php $this->endBlock()?>

<?php $this->beginBlock('pageSpecificJs')?>
<script src="/treetable/jquery.treetable.min.js"></script>
<script src="/js/functions-treetable.js"></script>
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineJs')?>
<script>
    makeTreeTable($(".treetable"),{column:1,initialState:"expanded"});
</script>
<?php $this->endBlock()?>
