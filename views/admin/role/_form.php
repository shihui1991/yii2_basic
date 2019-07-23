<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal']
]);

$parentId = isset($this->params['parent_id']) ? $this->params['parent_id'] : 0;
?>

<?= \app\helpers\DomHelper::getFormField($model, 'parent_id', 'formInput', $parentId, ['type'=>'number','required'=>'required','min'=>0,'max'=>10**10-1,'step'=>1])?>
<?= \app\helpers\DomHelper::getFormField($model, 'name', 'formInput','' ,['required'=>'required'])?>
<?= \app\helpers\DomHelper::getFormField($model, 'is_root','formRadio',$model::IS_ROOT_NO)?>

<?php

$menuIds = $model->getMenusIds();

$list = [];
$menus = \app\models\Menu::find()->isCtrl()->orderBySort()->all();
foreach($menus as $menu){
    $row = $menu->toArray();
    $row['checked'] = in_array($menu->id,$menuIds) ? 'checked' : '';
    $list[] = $row;
}

$tpl = "
 <tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
     <td><input type='checkbox' class='' name='menu_ids[]' value='\$id' onchange='upDown(this)' id='id-\$id' data-id='\$id' data-parent-id='\$parent_id' \$checked></td>
     <td>\$id</td>
     <td>\$icon \$name</td>
 </tr>
";

$tree = \app\helpers\HtmlHelper::makeTree($list,$tpl);

$content = <<<content
<div class="col-xs-10 col-sm-5">
    <table class="table table-bordered table-hover treetable">
        <caption> （角色为超管类型时不需要勾选） </caption>
        <thead>
        <tr>
            <th><input type="checkbox" class="" onchange="allCheckOrCancel(this)"></th>
            <th>ID</th>
            <th>名称</th>
        </tr>
        </thead>

        <tbody>
        {$tree}
        </tbody>
    </table>
</div>
content;

echo \app\helpers\AceHelper::formFieldDom('授权菜单',$content,['id' => '']);
?>


<?= \app\helpers\AceHelper::formSubmitBtn() ?>

<?php ActiveForm::end(); ?>

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
    makeTreeTable($(".treetable"),{column:2,initialState:"expanded"});
</script>
<?php $this->endBlock()?>
