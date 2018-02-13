<?php

namespace Itstructure\AdminModule;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Module as BaseModule;
use Itstructure\AdminModule\components\AdminView;

/**
 * Admin module class.
 *
 * @property string $layout
 * @property null|string|array $loginUrl
 * @property bool $isMultilanguage
 * @property array $accessRoles
 * @property AdminView $_view
 *
 * @package Itstructure\AdminModule
 */
class Module extends BaseModule
{
    /**
     * Main layout for other child templates.
     *
     * @var string
     */
    public $layout = '@admin/views/layouts/main-admin.php';

    /**
     * Login url.
     *
     * @var null|string|array
     */
    public $loginUrl = null;

    /**
     * Set multilanguage mode.
     *
     * @var bool
     */
    public $isMultilanguage = false;

    /**
     * Array of roles to module access.
     *
     * @var array
     */
    public $accessRoles = ['@'];

    /**
     * View component to render content.
     *
     * @var AdminView
     */
    private $_view = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@admin', static::getBaseDir());

        if (null !== $this->loginUrl) {
            Yii::$app->getUser()->loginUrl = $this->loginUrl;
        }

        $this->registerTranslations();

        /**
         * Set Profile validate component
         */
        $this->setComponents(
            ArrayHelper::merge(
                require __DIR__ . '/config/view.php',
                $this->components
            )
        );
    }

    /**
     * Returns module root directory.
     *
     * @return string
     */
    public static function getBaseDir(): string
    {
        return __DIR__;
    }

    /**
     * Module translator.
     *
     * @param       $category
     * @param       $message
     * @param array $params
     * @param null  $language
     *
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }

    /**
     * Set i18N component.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        Yii::$app->i18n->translations = ArrayHelper::merge(
            [
                'modules/admin/*' => [
                    'class'          => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => Yii::$app->language,
                    'basePath'       => '@admin/messages',
                    'fileMap'        => [
                        'modules/admin/main' => 'main.php',
                        'modules/admin/languages' => 'languages.php',
                        'modules/admin/admin-menu' => 'admin-menu.php',
                    ],
                ]
            ],
            Yii::$app->i18n->translations
        );
    }

    /**
     * Get the view.
     *
     * @return AdminView
     */
    public function getView()
    {
        if (null === $this->_view) {
            $this->_view = $this->get('view');
        }

        return $this->_view;
    }
}
