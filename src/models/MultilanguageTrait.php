<?php

namespace Itstructure\AdminModule\models;

use yii\db\ActiveQuery;
use Itstructure\AdminModule\components\MultilanguageMigration;

/**
 * Trait MultilanguageTrait
 *
 * @property \yii\db\ActiveRecord $this
 * @property Language[] $translateList list of related translated records.
 *
 * @package Itstructure\AdminModule\models
 */
trait MultilanguageTrait
{
    /**
     * Container for temporary storage of translation data.
     *
     * @var array
     */
    private $storage = [];

    /**
     * Return key name of relation between main table and translations table.
     *
     * @return string
     */
    public static function getKeyToMainModel()
    {
        return static::tableName() . '_id';
    }

    /**
     * Return translations table name.
     *
     * @return string
     */
    public static function getTranslateTablelName()
    {
        return static::tableName() . '_' . MultilanguageMigration::TRANSLATE_TABLE_POSTFIX;
    }

    /**
     * Return related translate model name.
     *
     * @return string
     */
    public static function getTranslateModelName()
    {
        $class = new \ReflectionClass(static::class);
        return $class->getNamespaceName() . '\\' . $class->getShortName() . ucfirst(MultilanguageMigration::TRANSLATE_TABLE_POSTFIX);
    }

    /**
     * Return related translated records.
     *
     * @return ActiveQuery
     */
    public function getTranslateList()
    {
        return $this->hasMany(static::getTranslateModelName(), [
            static::getKeyToMainModel() => 'id',
        ]);
    }

    /**
     * Override model magic getter. Return translate for field.
     * Example: if we try $model->title_en, we will get 'title' in english.
     *
     * @param string $name field name.
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        if (false === $this->isMultiLanguageField($name)) {
            return parent::__get($name);
        }

        list($field, $lang) = explode('_', $name);

        foreach ($this->translateList as $translate) {
            if ($translate->language->shortName === $lang) {
                return $translate->{$field};
            }
        }

        return null;
    }

    /**
     * Override model magic setter. Set translation for the field.
     * For example $model->title_en  will save title field in translate model where
     * language_id => record in language with 'en' locale.
     *
     * @param string $name  name of field.
     * @param mixed  $value value to be stored in field.
     *
     * @return void
     */
    public function __set($name, $value)
    {
        if (false === $this->isMultiLanguageField($name)) {
            parent::__set($name, $value);
            return;
        }

        list($field, $lang) = explode('_', $name);

        $this->storage[$lang][$field] = $value;
    }

    /**
     * Override model method to save all translations after main model saved.
     *
     * @return void
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        foreach ($this->storage as $lang => $fields) {

            foreach ($fields as $field => $value){

                $langModel = $this->findOrCreateTranslateModel($lang);
                $langModel->{$field} = $value;
                $langModel->save();
            }
        }
    }

    /**
     * Returns default translate. If field name is given, we can take an alternative
     * translate when default translate value is empty.
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getDefaultTranslate($field = null)
    {
        $mainRequest = $this->hasOne(static::getTranslateModelName(),
            [
                static::getKeyToMainModel() => 'id'
            ]
        );

        $defaultTranslate = $mainRequest->andWhere([
            MultilanguageMigration::getKeyToLanguageTable() => Language::findOne([
                'default' => 1
            ])->id
        ]);

        if ($field != null && $defaultTranslate->andWhere(['!=', $field, ''])->count() == 0){

            $result = $mainRequest->where([
                '!=', $field, ''
            ])->one();

            return $result == null ? '-' : $result->{$field};
        }

        return $field == null ? $defaultTranslate->one() : $defaultTranslate->one()->{$field};
    }

    /**
     * Check for multi-language mode of field.
     *
     * @param string $name name of field to be checked.
     *
     * @return boolean
     */
    private function isMultiLanguageField($name): bool
    {
        if (false === strpos($name, '_')) {
            return false;
        }

        list(, $lang) = explode('_', $name);

        if (null === $lang) {
            return false;
        }

        if (false === in_array($lang, Language::getShortLanguageList(), true)) {
            return false;
        }

        return true;
    }

    /**
     * Find or create related model with translates.
     *
     * @param string $lang language short name.
     *
     * @return mixed
     */
    private function findOrCreateTranslateModel($lang)
    {
        $language = Language::findOne(['shortName' => $lang]);

        $translateModel = call_user_func([
            static::getTranslateModelName(),
            'find',
        ]);
        $translateModel = $translateModel->where([
            static::getKeyToMainModel() => $this->id,
        ])->andWhere([
            MultilanguageMigration::getKeyToLanguageTable() => $language->id,
        ])->one();

        if (null === $translateModel) {
            $translateModelName = static::getTranslateModelName();
            $translateModel = new $translateModelName;
            $translateModel->{static::getKeyToMainModel()} = $this->id;
            $translateModel->{MultilanguageMigration::getKeyToLanguageTable()} = $language->id;
        }

        return $translateModel;
    }
}
