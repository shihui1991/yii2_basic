<?php
/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginPage()?>

    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="<?= Yii::$app->charset ?>" />
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= $this->title ?></title>
        <?php $this->head() ?>

        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="/ace/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/ace/font-awesome/4.7.0/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->
        <?= isset($this->blocks['pageSpecificCss']) ? $this->blocks['pageSpecificCss'] : '' ?>

        <!-- ace styles -->
        <link rel="stylesheet" href="/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

        <!--[if lte IE 9]>
        <link rel="stylesheet" href="/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
        <link rel="stylesheet" href="/ace/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->
        <?= isset($this->blocks['inlineCss']) ? $this->blocks['inlineCss'] : '' ?>

        <!-- ace settings handler -->
        <script src="/ace/js/ace-extra.min.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="/ace/js/html5shiv.min.js"></script>
        <script src="/ace/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="<?= isset($this->params['bodyClass']) ? $this->params['bodyClass'] : '' ?>">
    <?php $this->beginBody() ?>

    <?= $content ?>

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="/ace/js/jquery-2.1.4.min.js"></script>

    <!-- <![endif]-->

    <!--[if IE]>
    <script src="/ace/js/jquery-1.11.3.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='/ace/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="/ace/js/bootstrap.min.js"></script>

    <!-- page specific plugin scripts -->
    <?= isset($this->blocks['pageSpecificJs']) ? $this->blocks['pageSpecificJs'] : '' ?>

    <!-- ace scripts -->
    <script src="/ace/js/ace-elements.min.js"></script>
    <script src="/ace/js/ace.min.js"></script>

    <!-- inline scripts related to this page -->
    <?= isset($this->blocks['inlineJs']) ? $this->blocks['inlineJs'] : '' ?>

    <?php $this->endBody() ?>
    </body>
    </html>


<?php $this->endPage()?>