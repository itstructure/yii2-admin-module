<?php

/* @var $this Itstructure\AdminModule\components\AdminView */
/* @var $content string */

use yii\helpers\Html;
use Itstructure\AdminModule\Module;
use Itstructure\AdminModule\widgets\menu\{MainMenu, AdminMenu};

if (!isset($this->params['subTitle'])) {
    $this->params['subTitle'] = '';
}

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo Html::encode($this->title) ?></title>
        <?php echo Html::csrfMetaTags() ?>
        <?php $this->head() ?>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    </head>
    <body class="<?php echo $this->skin ?> <?php echo $this->bodyLayout ?>">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <header class="main-header">

            <a href="<?php echo $this->homeUrl ?>" class="logo">
                <span class="logo-mini"><b><?php echo $this->shotCompanyName ?></b></span>
                <span class="logo-lg"><b><?php echo $this->companyName ?></b></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button -->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php echo AdminMenu::widget([
                            'user'        => $this->params['user'],
                            'profileLink' => $this->profileLink,
                            'signOutLink' => $this->signOutLink,
                            'userBody'    => $this->userBody,
                        ]) ?>
                    </ul>
                </div>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <?php echo MainMenu::widget($this->mainMenuConfig); ?>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $this->title ?>
                    <small><?php echo $this->params['subTitle'] ?></small>
                </h1>
                <?php echo \yii\widgets\Breadcrumbs::widget([
                    'tag'      => 'ol',
                    'homeLink' => [
                        'label' => Module::t('main', 'Home'),
                        'url'   => $this->homeUrl,
                    ],
                    'links'    => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </section>

            <section class="content container-fluid">
                <?php echo $content ?>
            </section>
        </div>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> <?php echo \Yii::$app->version ?>
            </div>
            <strong>Copyright
                &copy; <?php echo date('Y') ?> <?php echo $this->companyName ?></strong>
            All rights reserved.
        </footer>

        <div class="control-sidebar-bg"></div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>