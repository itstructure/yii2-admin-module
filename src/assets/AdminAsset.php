<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace Itstructure\AdminModule\assets;

use yii\base\Exception;
use yii\web\{AssetBundle, JqueryAsset, YiiAsset};
use yii\bootstrap\{BootstrapAsset, BootstrapPluginAsset};

/**
 * Main application asset bundle.
 *
 * @package Itstructure\AdminModule\assets
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    /**
     * @var string
     */
    public $skin = '_all-skins';
    public $css = [
        'bower_components/bootstrap/dist/css/bootstrap.min.css',
        'bower_components/font-awesome/css/font-awesome.min.css',
        'bower_components/Ionicons/css/ionicons.min.css',
        'bower_components/jvectormap/jquery-jvectormap.css',
        'dist/css/AdminLTE.min.css',
    ];
    public $js = [
        'bower_components/jquery/dist/jquery.min.js',
        'bower_components/fastclick/lib/fastclick.js',
        'dist/js/adminlte.min.js',
        'bower_components/jquery-sparkline/dist/jquery.sparkline.min.js',
        'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'bower_components/Chart.js/Chart.js',

        //'bower_components/bootstrap/dist/js/bootstrap.min.js', // If this is loaded, you may
        // experience a problem displaying the admin menu.
    ];

    public $jsOptions = [
        'position' => \yii\web\View::POS_HEAD
    ];

    public $depends = [
        BootstrapAsset::class,
        JqueryAsset::class,
        BootstrapPluginAsset::class,
        YiiAsset::class
    ];

    public function init()
    {
        if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }
            $this->css[] = sprintf('dist/css/skins/%s.min.css', $this->skin);
        }

        parent::init();
    }
}
