<?php
/* @var $this \yii\web\View */
/* @var $content string */

$this->params['bodyClass'] = 'login-layout';
?>

<?php $this->beginContent('@app/views/layouts/ace.php') ?>

<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <div class="center">
                        <h1>
                            <i class="ace-icon fa fa-leaf green"></i>
                            <span class="red"></span>
                            <span class="white" id="id-text2">后台管理</span>
                        </h1>
                        <h4 class="blue" id="id-company-text">&copy; company</h4>
                    </div>

                    <div class="space-6"></div>

                    <div class="position-relative">
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <?= $content ?>
                        </div><!-- /.login-box -->

                    </div><!-- /.position-relative -->

                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.main-content -->
</div><!-- /.main-container -->

<?php $this->endContent() ?>
