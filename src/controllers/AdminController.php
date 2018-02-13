<?php

namespace Itstructure\AdminModule\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\{VerbFilter, AccessControl};

/**
 * Class AdminController
 * Default controller for the `admin` module.
 *
 * @package Itstructure\AdminModule\controllers
 */
class AdminController extends Controller
{
    /**
     * Initialize.
     *
     * @return void
     */
    public function init()
    {
        $this->view->params['user'] = Yii::$app->user->identity;
    }

    /**
     *
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
     *
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
