<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Master */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal']
]);

?>

<?= \app\helpers\DomHelper::getFormField($model, 'name', 'formInput','' ,['required'=>'required'])?>
<?= \app\helpers\DomHelper::getFormField($model, 'username', 'formInput','' ,['required'=>'required'])?>
<?= \app\helpers\DomHelper::getFormField($model, 'password', 'formInput','' ,['required'=>'required'])?>
<?= \app\helpers\DomHelper::getFormField($model, 'status','formRadio',$model::STATUS_ON)?>

<?php

$roleIds = $model->getRolesIds();

$list = [];
$roles = \app\models\Role::find()->all();
foreach($roles as $role){
    $row = $role->toArray();
    $row['checked'] = in_array($role->id,$roleIds) ? 'checked' : '';
    $row['is_root'] = $role->getValueDesc('is_root',$role->is_root);
    $list[] = $row;
}

$tpl = "
 <tr data-tt-id='\$id' data-tt-parent-id='\$parent_id'>
     <td><input type='checkbox' class='' name='role_ids[]' value='\$id' onchange='upDown(this)' id='id-\$id' data-id='\$id' data-parent-id='\$parent_id' \$checked></td>
     <td>\$id</td>
     <td>\$name</td>
     <td>\$is_root</td>
 </tr>
";

$tree = \app\helpers\HtmlHelper::makeTree($list,$tpl);

$content = <<<content
<div class="col-xs-10 col-sm-5">
    <table class="table table-bordered table-hover treetable">
        <thead>
        <tr>
            <th><input type="checkbox" class="" onchange="allCheckOrCancel(this)"></th>
            <th>ID</th>
            <th>名称</th>
            <th>是否超管</th>
        </tr>
        </thead>

        <tbody>
        {$tree}
        </tbody>
    </table>
</div>
content;

echo \app\helpers\AceHelper::formFieldDom('角色',$content,['id' => '']);
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
