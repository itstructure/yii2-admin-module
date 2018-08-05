<?php

namespace Itstructure\AdminModule\controllers;

use yii\web\NotFoundHttpException;
use Itstructure\AdminModule\models\{Language, LanguageSearch};

/**
 * Class LanguageController
 * LanguageController implements the CRUD actions for Language model.
 *
 * @package Itstructure\AdminModule\controllers
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class LanguageController extends CommonAdminController
{
    /**
     * Initialize.
     */
    public function init()
    {
        $this->viewPath = '@admin/views/language';

        parent::init();
    }

    /**
     * Set language as default.
     *
     * @param $languageId
     *
     * @return \yii\web\Response
     *
     * @throws NotFoundHttpException
     */
    public function actionSetDefault($languageId)
    {
        $language = Language::findOne($languageId);
        if (null === $language) {
            throw  new NotFoundHttpException('Language with id ' . $languageId . ' does not exist');
        }

        $language->default = !$language->default;
        $language->save();

        return $this->redirect('index');
    }

    /**
     * Returns Language model name.
     *
     * @return string
     */
    protected function getModelName():string
    {
        return Language::class;
    }

    /**
     * Returns LanguageSearch model name.
     *
     * @return string
     */
    protected function getSearchModelName():string
    {
        return LanguageSearch::class;
    }
}
