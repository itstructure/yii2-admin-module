<?php

namespace Itstructure\AdminModule;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\Module as BaseModule;
use Itstructure\AdminModule\components\AdminView;

/**
 * Admin module class.
 *
 * @property string $layout Main layout for other child templates.
 * @property null|string|array $loginUrl Login url.
 * @property bool $isMultilanguage Set multilanguage mode.
 * @property array $accessRoles Array of roles to module access.
 * @property AdminView $_view View component to render content.
 *
 * @package Itstructure\AdminModule
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Module extends BaseModule
{
    /**
     * Main layout for other child templates.
     * @var string
     */
    public $layout = '@admin/views/layouts/main-admin.php';

    /**
     * Login url.
     * @var null|string|array
     */
    public $loginUrl = null;

    /**
     * Set multilanguage mode.
     * @var bool
     */
    public $isMultilanguage = false;

    /**
     * Array of roles to module access.
     * @var array
     */
    public $accessRoles = ['@'];

    /**
     * View component to render content.
     * @var AdminView
     */
    private $_view = null;

    /**
     * Module translations.
     * @var array|null
     */
    private static $_translations = null;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::setAlias('@admin', static::getBaseDir());

        if (null !== $this->loginUrl && method_exists(Yii::$app, 'getUser')) {
            Yii::$app->getUser()->loginUrl = $this->loginUrl;
        }

        self::registerTranslations();

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
     * Get the view.
     * @return AdminView
     */
    public function getView()
    {
        if (null === $this->_view) {
            $this->_view = $this->get('view');
        }

        return $this->_view;
    }

    /**
     * Returns module root directory.
     * @return string
     */
    public static function getBaseDir(): string
    {
        return __DIR__;
    }

    /**
     * Module translator.
     * @param       $category
     * @param       $message
     * @param array $params
     * @param null  $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        if (null === self::$_translations){
            self::registerTranslations();
        }

        return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }

    /**
     * Set i18N component.
     * @return void
     */
    private static function registerTranslations(): void
    {
        self::$_translations = [
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
        ];

        Yii::$app->i18n->translations = ArrayHelper::merge(
            self::$_translations,
            Yii::$app->i18n->translations
        );
    }
}
