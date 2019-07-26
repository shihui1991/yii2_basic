<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Master */

$this->title = '添加用户';

?>

<div class="well">
    <a href="<?= Url::toRoute('index')?>" class="btn btn-default"><i class="ace-icon fa fa-arrow-left"></i>返回列表</a>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
