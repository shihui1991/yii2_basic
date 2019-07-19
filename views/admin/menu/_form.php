<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<?php if($errors = Yii::$app->session->getFlash('errors')): ?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>

        <ul>
            <?php foreach($errors as $i => $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif ?>

<div class="menu-form">

    <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal']
    ]);

    $parentId = isset($this->params['parent_id']) ? $this->params['parent_id'] : 0;
    ?>

    <?= \app\helpers\DomHelper::getFormField($model, 'parent_id', 'formInput', $parentId, ['type'=>'number','required'=>'required','min'=>0,'max'=>10**10-1,'step'=>1])?>
    <?= \app\helpers\DomHelper::getFormField($model, 'name', 'formInput','' ,['required'=>'required'])?>
    <?= \app\helpers\DomHelper::getFormField($model, 'uri')?>
    <?= \app\helpers\DomHelper::getFormField($model, 'router')?>
    <?= \app\helpers\DomHelper::getFormField($model, 'icon')?>
    <?= \app\helpers\DomHelper::getFormField($model, 'is_ctrl','formRadio',$model::IS_CTRL_YES)?>
    <?= \app\helpers\DomHelper::getFormField($model, 'is_show','formRadio',$model::IS_SHOW_NO)?>
    <?= \app\helpers\DomHelper::getFormField($model, 'status','formRadio',$model::STATUS_ON)?>
    <?= \app\helpers\DomHelper::getFormField($model, 'sort','formInput',0,['type'=>'number','min'=>0,'max'=>10**10-1,'step'=>1])?>

    <?= \app\helpers\AceHelper::formSubmitBtn() ?>

    <?php ActiveForm::end(); ?>

</div>
