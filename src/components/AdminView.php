<?php

namespace Itstructure\AdminModule\components;

use yii\web\View;
use yii\base\InvalidConfigException;
use Itstructure\AdminModule\assets\AdminAsset;

/**
 * Class AdminView
 * Default view for the Admin View
 *
 * @property array $mainMenuConfig Sidebar menu config.
 * @property string $bodyLayout Admin layout type.
 * @property string $skin Admin layout theme. By default are used blue skin.
 * @property null|array|string $assetBundleConfig AssetBundle config.
 * @property string $homeUrl Home URL.
 * @property array $extraAssets An array of extra asset. Each asset can be specified one of the following format:
 * - a string thar represent a class name of extra asset;
 * - an array that must contain a class key and may contain other settings of asset bundle.
 * @see BaseYii::createObject()
 * @property string[] $userBody This array contain a key->value pairs where key - is link name and value is link
 * that will be rendered in "user-body" section of menu.
 * @property string $defaultAssetBundleClass Asset bundle class-name using by default for admin view.
 * @property string $companyName Company name.
 * @property string $shotCompanyName Short company name.
 * @property string $profileLink Link to user profile.
 * @property string $signOutLink Link to sign-out action.
 *
 * @package Itstructure\AdminModule\components
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class AdminView extends View
{
    /**
     * Layouts.
     */
    const LAYOUT_FIXED = 'fixed';
    const LAYOUT_SIDEBAR_MINI = 'sidebar-mini';
    const LAYOUT_SIDEBAR_COLLAPSE = 'sidebar-collapse';
    const LAYOUT_BOXED = 'layout-boxed';
    const LAYOUT_TOP_NAV = 'layout-top-nav';

    /**
     * Skins.
     */
    const SKIN_BLUE = 'skin-blue';
    const SKIN_BLUE_LIGHT = 'skin-blue-light';
    const SKIN_YELLOW = 'skin-yellow';
    const SKIN_YELLOW_LIGHT = 'skin-yellow-light';
    const SKIN_GREEN = 'skin-green';
    const SKIN_GREEN_LIGHT = 'skin-green-light';
    const SKIN_PURPLE = 'skin-purple';
    const SKIN_PURPLE_LIGHT = 'skin-purple-light';
    const SKIN_RED = 'skin-red';
    const SKIN_RED_LIGHT = 'skin-red-light';
    const SKIN_BLACK = 'skin-black';
    const SKIN_BLACK_LIGHT = 'skin-black-light';

    /**
     * Sidebar menu config.
     * @var array
     */
    public $mainMenuConfig = [];

    /**
     * Admin layout type.
     * @var string
     */
    public $bodyLayout = self::LAYOUT_SIDEBAR_MINI;

    /**
     * Admin layout theme. By default are used blue skin.
     * @var string
     */
    public $skin = self::SKIN_BLUE;

    /**
     * AssetBundle config.
     * @var null|array|string
     */
    public $assetBundleConfig = null;

    /**
     * Home URL.
     * @var string
     */
    public $homeUrl = '/admin';

    /**
     * An array of extra asset. Each asset can be specified one of the following format:
     * - a string thar represent a class name of extra asset;
     * - an array that must contain a class key and may contain other settings of asset bundle.
     * @see BaseYii::createObject()
     * @var array
     */
    public $extraAssets = [];

    /**
     * This array contain a key->value pairs where key - is link name and value is link
     * that will be rendered in "user-body" section of menu.
     * @var string[]
     */
    public $userBody = [];

    /**
     * Asset bundle class-name using by default for admin view.
     * @var string
     */
    private $defaultAssetBundleClass = AdminAsset::class;

    /**
     * Company name.
     * @var string
     */
    public $companyName = 'Company';

    /**
     * Short company name.
     * @var string
     */
    public $shotCompanyName = '';

    /**
     * Link to user profile.
     * @var string
     */
    public $profileLink = '/profile';

    /**
     * Link to sign-out action.
     * @var string
     */
    public $signOutLink = '/site/logout';

    /**
     * Initializes the object.
     * @return void
     */
    public function init(): void
    {
        $this->registerAdminAsset();
        $this->registerExtraAssets();
    }

    /**
     * Register a main admin asset.
     * @return void
     */
    private function registerAdminAsset(): void
    {
        $assetConfig = $this->getAdminAssetConfig();
        $this->registerAsset($assetConfig);
    }

    /**
     * Register an extra assets.
     * @return void
     */
    private function registerExtraAssets(): void
    {
        foreach ($this->extraAssets as $asset) {
            $assetConfig = $this->getExtraAssetConfig($asset);
            $this->registerAsset($assetConfig);
        }
    }

    /**
     * Register an asset bundle in view.
     * @param array $assetConfig config of asset bundle.
     * @return void
     */
    private function registerAsset(array $assetConfig): void
    {
        $assetClassName = $assetConfig['class'];
        $this->assetManager->bundles[$assetClassName] = $assetConfig;
        if (method_exists($assetClassName, 'register')) {
            call_user_func([
                $assetClassName,
                'register',
            ], $this);
        }
    }

    /**
     * Return config array for create instance of AssetBundle.
     * @return array
     */
    private function getAdminAssetConfig(): array
    {
        $config = $this->assetBundleConfig;
        if (null === $config) {
            $config = [];
        }
        if (is_string($config)) {
            $config['class'] = $config;
        }
        if (is_array($config) && !array_key_exists('class', $config)) {
            $config['class'] = $this->defaultAssetBundleClass;
            if (array_key_exists('skin', $config)) {
                $config['skin'] = $this->skin;
            }
        }

        return $config;
    }

    /**
     * Prepare and return an extra asset config.
     * @param string|array $asset extra asset config.
     * @throws InvalidConfigException if the configuration is invalid.
     * @return array
     */
    private function getExtraAssetConfig($asset): array
    {
        $config = [];
        if (is_string($asset)) {
            $config['class'] = $asset;
        } else {
            $config = $asset;
        }
        if (false === array_key_exists('class', $config)) {
            throw new InvalidConfigException('Object configuration must be an array containing a "class" element.');
        }

        return $config;
    }
}
