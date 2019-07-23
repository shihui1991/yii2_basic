<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Role */

$this->title = '角色详情';

?>

<div class="well">
    <a href="<?= Url::toRoute('index')?>" class="btn btn-default"><i class="ace-icon fa fa-arrow-left"></i>返回列表</a>
    <a href="<?= Url::toRoute(['create','parent_id' => $model->id])?>" class="btn btn-success"><i class="ace-icon fa fa-plus"></i>添加下级</a>
    <a href="<?= Url::toRoute(['update','id' => $model->id])?>" class="btn btn-primary"><i class="ace-icon fa fa-edit"></i>修改</a>
    <a class="btn btn-danger" onclick="btnFormAjaxRequest(this)" data-msg="是否确定删除吗？" data-url="<?= Url::toRoute(['delete','id' => $model->id]) ?>" data-type="DELETE"><i class="ace-icon fa fa-trash"></i>删除</a>
</div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => $model->fieldsInfo(),
])?>


<?php

$list = [];
if($model::IS_ROOT_YES == $model->is_root){
    $menus = \app\models\Menu::find()->isCtrl()->orderBySort()->all();
}else{
    $menus = $model->menus;
}

foreach($menus as $menu){
    $row = $menu->toArray();
    $list[] = $row;
}

$tpl = "
 <tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
     <td>\$id</td>
     <td>\$icon \$name</td>
 </tr>
";

$tree = \app\helpers\HtmlHelper::makeTree($list,$tpl);

?>

<table class="table table-bordered table-hover treetable">
    <caption> 授权菜单 </caption>
    <thead>
    <tr>
        <th>ID</th>
        <th>名称</th>
    </tr>
    </thead>

    <tbody>
    <?= $tree ?>
    </tbody>
</table>

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