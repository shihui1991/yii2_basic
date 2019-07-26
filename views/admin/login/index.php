<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $list  */

$this->title = '登录';

?>


<div class="widget-body">
    <div class="widget-main">
        <h4 class="header blue lighter bigger">
            <i class="ace-icon fa fa-coffee green"></i>
            请登录
        </h4>

        <div class="space-6"></div>

        <?= \app\widgets\Alert::widget() ?>

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-horizontal'],
        ]);
        ?>
        <fieldset>
            <label class="block clearfix">
					<span class="block input-icon input-icon-right">
						<input type="text" class="form-control" placeholder="请输入 用户名" name="Master[username]" required/>
						<i class="ace-icon fa fa-user"></i>
					</span>
            </label>

            <label class="block clearfix">
					<span class="block input-icon input-icon-right">
						<input type="password" class="form-control" placeholder="请输入 密码" name="Master[password]" required/>
						<i class="ace-icon fa fa-lock"></i>
					</span>
            </label>

            <div class="space"></div>

            <div class="clearfix">

                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                    <i class="ace-icon fa fa-key"></i>
                    <span class="bigger-110">登录</span>
                </button>
            </div>

            <div class="space-4"></div>
        </fieldset>

        <?php ActiveForm::end(); ?>

    </div><!-- /.widget-main -->
</div><!-- /.widget-body -->
