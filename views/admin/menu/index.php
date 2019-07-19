<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $list  */

$this->title = '菜单列表';

?>

<div class="well">
    <a href="<?= Url::toRoute('create')?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加顶级菜单</a>
    <a class="btn btn-warning" onclick="btnFormAjaxRequest(this)" data-msg="是否确定执行批量排序？" data-form="#batch-action-form" data-url="<?= Url::toRoute('sort') ?>"> 更新排序 </a>
</div>

<form action="" id="batch-action-form" method="post">
<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="allCheckOrCancel(this)"> ID</th>
        <th>名称</th>
        <th>URI</th>
        <th>是否限制</th>
        <th>是否显示</th>
        <th>状态</th>
        <th>排序</th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php
    $dataList = [];
    foreach($list as $i => $model){
        $dataList[$i] = $model->toArray();
        $dataList[$i]['is_ctrl'] = $model->getValueDesc('is_ctrl',$model->is_ctrl);
        $dataList[$i]['is_show'] = $model->getValueDesc('is_show',$model->is_show);
        $dataList[$i]['status'] = $model->getValueDesc('status',$model->status);
        $dataList[$i]['url_create'] = Url::toRoute(['create','parent_id' => $model->id]);
        $dataList[$i]['url_view'] = Url::toRoute(['view','id' => $model->id]);
        $dataList[$i]['url_update'] = Url::toRoute(['update','id' => $model->id]);
        $dataList[$i]['url_delete'] = Url::toRoute(['delete','id' => $model->id]);
    }
    $tpl = "
 <tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
     <td><input type='checkbox' name='ids[]' value='\$id'> \$id</td>
     <td>\$space \$icon \$name</td>
     <td>\$uri</td>
     <td>\$is_ctrl</td>
     <td>\$is_show</td>
     <td>\$status</td>
     <td>
         <p contenteditable='true' class='p-sort'>\$sort</p>
         <input type='hidden' class='input-sort' name='sorts[\$id]' value='\$sort'>
     </td>
     <td>
         <div class='btn-group'>
             <a href='\$url_create' class='btn btn-xs btn-success'><i class='ace-icon fa fa-plus'></i>添加下级</a>
             <a href='\$url_view' class='btn btn-xs btn-info'><i class='ace-icon fa fa-info-circle'></i>详情</a>
             <a href='\$url_update' class='btn btn-xs btn-primary'><i class='ace-icon fa fa-pencil-square-o'></i>修改</a>
             <a href='\$url_delete' class='btn btn-xs btn-danger'><i class='ace-icon fa fa-trash-o'></i>删除</a>
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
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineCss')?>
<style>
    .p-sort{height:100%}
</style>
<?php $this->endBlock()?>

<?php $this->beginBlock('pageSpecificJs')?>
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineJs')?>
<script>
    $(".p-sort").on("change blur",function(){
        var sort = $(this).text();
        var input = $(this).next("input.input-sort");
        var origin = input.val();
        if(! (sort > -1)){
            alert("输入排序数值非法");
            $(this).text(origin);
            return false;
        }
        input.val(parseInt(sort));
    });
</script>
<?php $this->endBlock()?>
