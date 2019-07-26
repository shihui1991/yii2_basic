<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $master \app\models\Master */
/* @var $action */

?>

<div id="user-profile-2" class="user-profile">
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="<?= 'profile' == $action ? 'active' : ''?>">
                <a data-toggle="tab" href="#profile">
                    <i class="green ace-icon fa fa-user bigger-120"></i>
                    个人信息
                </a>
            </li>

            <li class="<?= 'password' == $action ? 'active' : ''?>">
                <a data-toggle="tab" href="#password">
                    <i class="orange ace-icon fa fa-key bigger-120"></i>
                    修改密码
                </a>
            </li>
        </ul>

        <div class="tab-content no-border padding-24">
            <div id="profile" class="tab-pane <?= 'profile' == $action ? ' in active' : ''?>">
                <div class="row">
                    <div class="col-xs-12 col-sm-3 center">
						<span class="profile-picture">
							<img class="editable img-responsive" alt="Alex's Avatar" id="avatar2" src="/ace/images/avatars/profile-pic.jpg" />
						</span>

                        <div class="space space-4"></div>

                    </div><!-- /.col -->

                    <div class="col-xs-12 col-sm-9">
                        <?php $form = ActiveForm::begin([
                            'options' => ['class' => 'form-horizontal'],
                        ]);

                        ?>
                        <div class="profile-user-info">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> ID： </div>

                                <div class="profile-info-value">
                                    <span><?= $master->id ?></span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 角色： </div>

                                <div class="profile-info-value">
                                    <span>
                                    <?php foreach($master->roles as $role): ?>
                                        <?= $role->name ?> &nbsp;
                                    <?php endforeach;?>
                                    </span>
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 姓名： </div>

                                <div class="profile-info-value">
                                    <span class="input-span" contenteditable="true"><?= $master->name ?></span>
                                    <input type="hidden" name="Master[name]" value="<?= $master->name ?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> 用户名： </div>

                                <div class="profile-info-value">
                                    <span class="input-span" contenteditable="true"><?= $master->username ?></span>
                                    <input type="hidden" name="Master[username]" value="<?= $master->username ?>">
                                </div>
                            </div>

                            <div class="profile-info-row">
                                <div class="profile-info-name"> </div>

                                <div class="profile-info-value">
                                    <span class="save-profile hidden">
                                    <button class="btn btn-sm btn-info" type="submit"><i class="ace-icon fa fa-check bigger-110"></i>保存</button>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <?php ActiveForm::end(); ?>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /#profile -->

            <div id="password" class="tab-pane <?= 'password' == $action ? 'in active' : ''?>">
                <div class="space-10"></div>
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal'],
                    'action' => Url::toRoute(['password']),
                ]);

                ?>

                <div class="form-group ">
                    <label class="col-sm-3 control-label no-padding-right" for="field-old_password"> 原密码 </label>
                    <div class="col-sm-9">
                        <input id="field-old_password" name="Master[old_password]" class="col-xs-10 col-sm-5" required="required" type="password" value="">
                        <div class="help-block col-xs-12 col-sm-reset inline"></div>
                    </div>
                </div>

                <div class="space-4"></div>

                <div class="form-group ">
                    <label class="col-sm-3 control-label no-padding-right" for="field-password"> 新密码 </label>
                    <div class="col-sm-9">
                        <input id="field-password" name="Master[password]" class="col-xs-10 col-sm-5" required="required" type="password" value="">
                        <div class="help-block col-xs-12 col-sm-reset inline"></div>
                    </div>
                </div>

                <div class="space-4"></div>

                <div class="form-group ">
                    <label class="col-sm-3 control-label no-padding-right" for="field-password_confirm"> 确认密码 </label>
                    <div class="col-sm-9">
                        <input id="field-password_confirm" name="Master[password_confirm]" class="col-xs-10 col-sm-5" required="required" type="password" value="">
                        <div class="help-block col-xs-12 col-sm-reset inline"></div>
                    </div>
                </div>

                <div class="space-4"></div>

                <?= \app\helpers\AceHelper::formSubmitBtn() ?>

                <?php ActiveForm::end(); ?>
            </div><!-- /#password -->

        </div>
    </div>
</div>


<?php $this->beginBlock('pageSpecificCss')?>

<?php $this->endBlock()?>

<?php $this->beginBlock('inlineCss')?>
<style>
.input-span{height: 100%;}
</style>
<?php $this->endBlock()?>

<?php $this->beginBlock('pageSpecificJs')?>

<?php $this->endBlock()?>

<?php $this->beginBlock('inlineJs')?>
<script>
$('.input-span').on('blur',function () {
    var val = $(this).text();
    var input = $(this).next('input:hidden');
    var old = input.val();
    input.val(val);
    if(val != old) {
        $('.save-profile').removeClass('hidden');
    }
});
</script>
<?php $this->endBlock()?>
