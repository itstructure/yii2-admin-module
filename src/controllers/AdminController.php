<?php

namespace Itstructure\AdminModule\controllers;

use Yii;
use yii\web\Controller;
use Itstructure\AdminModule\Module;
use yii\filters\{VerbFilter, AccessControl};

/**
 * Class AdminController
 * Default controller for the `admin` module.
 *
 * @property Module $module
 * @property string $urlPrefix Url prefix for redirect and view links.
 * @property string $urlPrefixNeighbor Url prefix for redirect and view links of neighbor entity.
 *
 * @package Itstructure\AdminModule\controllers
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class AdminController extends Controller
{
    /**
     * Url prefix for redirect and view links.
     * @var string
     */
    protected $urlPrefix = '';

    /**
     * Url prefix for redirect and view links of neighbor entity.
     * @var string
     */
    protected $urlPrefixNeighbor = '';

    /**
     * Initialize.
     * @return void
     */
    public function init()
    {
        $this->view->params['user'] = Yii::$app->user->identity;
    }

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->view->params['urlPrefix']         = $this->urlPrefix;
        $this->view->params['urlPrefixNeighbor'] = $this->urlPrefixNeighbor;

        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->accessRoles,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => [
                        'POST',
                    ],
                ],
            ],
        ];
    }

    /**
     * Give ability of configure view to the module class.
     * @return \yii\base\View|\yii\web\View
     */
    public function getView()
    {
        if (method_exists($this->module, 'getView')) {
            return $this->module->getView();
        }

        return parent::getView();
    }
}
