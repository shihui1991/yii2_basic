<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Menu', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'parent_id',
//            'parents_ids',
            'name',
            'uri',
            //'router',
            //'icon',
            'is_ctrl',
            'is_show',
            'status',
            'sort',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

<?php $this->beginBlock('pageSpecificCss')?>
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineCss')?>
<?php $this->endBlock()?>

<?php $this->beginBlock('pageSpecificJs')?>
<script src="/js/functions-jquery.js"></script>
<?php $this->endBlock()?>

<?php $this->beginBlock('inlineJs')?>
<script>

</script>
<?php $this->endBlock()?>
