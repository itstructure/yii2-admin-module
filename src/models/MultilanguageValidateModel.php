<?php

namespace Itstructure\AdminModule\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use Itstructure\AdminModule\interfaces\ModelInterface;

/**
 * Class MultilanguageValidateModel
 * General validation model together with multilingual fields.
 *
 * @property array $dynamicFields Dynamic fields from which the translated fields are formed.
 * @property ActiveRecord|MultilanguageTrait $mainModel Basic data model.
 *
 * @package Itstructure\AdminModule\models
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class MultilanguageValidateModel extends Model implements ModelInterface
{
    /**
     * Dynamic fields from which the translated fields are formed.
     * @var array
     */
    public $dynamicFields = [];

    /**
     * Basic data model.
     * @var ActiveRecord|MultilanguageTrait
     */
    public $mainModel;

    /**
     * Scripts Constants.
     * Required for certain validation rules to work for specific scenarios.
     */
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    /**
     * Validation rules for all fields together with dynamic.
     * @return array
     */
    public function rules(): array
    {
        return ArrayHelper::merge(
            $this->getDynamicValidationRules(),
            $this->mainModel->rules()
        );
    }

    /**
     * Scenarios.
     * @return array
     */
    public function scenarios(): array
    {
        return [
            self::SCENARIO_CREATE => $this->attributes(),
            self::SCENARIO_UPDATE => $this->attributes(),
            self::SCENARIO_DEFAULT => $this->attributes(),
        ];
    }

    /**
     * Labels of all fields.
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $dynamicAttributeLabels = [];
        $staticAttributeLabels = [];

        $translateAttributeLabels = call_user_func([
            $this->mainModel->getTranslateModelName(),
            'attributeLabels',
        ]);

        foreach ($this->dynamicFields as $fieldConditions) {

            $fieldName = $fieldConditions['name'];

            if (array_key_exists($fieldName, $translateAttributeLabels)){

                $staticAttributeLabels[$fieldName] = $translateAttributeLabels[$fieldName];

                foreach ($this->getShortLanguageList() as $language) {
                    $dynamicAttributeLabels[$fieldName.'_'.$language] = $translateAttributeLabels[$fieldName];
                }
            }
        }

        return ArrayHelper::merge(
            ArrayHelper::merge(
                $dynamicAttributeLabels,
                $staticAttributeLabels
            ),
            $this->mainModel->attributeLabels()
        );
    }

    /**
     * Gets the value of the field.
     * @param string $name - field name.
     * @return mixed
     */
    public function __get($name)
    {
        if ($this->mainModel->isNewRecord){
            return $this->{$name} ?? '';
        } else {
            return $this->mainModel->{$name} ?? '';
        }
    }

    /**
     * Specifies the value of the field.
     * @param string $name - name of field.
     * @param mixed  $value - value to be stored in field.
     * @return void
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    /**
     * Attributes along with dynamic and from the basic model.
     * @return array
     */
    public function attributes(): array
    {
        return ArrayHelper::merge(
            $this->getDynamicAttributes(),
            $this->mainModel->attributes()
        );
    }

    /**
     * Saves data in the main model.
     * @return bool
     */
    public function save(): bool
    {
        if ($this->mainModel->isNewRecord){
            $this->setScenario(self::SCENARIO_CREATE);
        } else {
            $this->setScenario(self::SCENARIO_UPDATE);
        }

        if (!$this->validate()){
            return false;
        }

        // Transferring attribute values from this model to the main.
        foreach ($this->attributes() as $attribute) {

            $this->mainModel->{$attribute} = $this->{$attribute};
        }

        return $this->mainModel->save();
    }

    /**
     * Returns the id of the current model.
     * @return int
     */
    public function getId()
    {
        return $this->mainModel->id;
    }

    /**
     * Returns an array of all multilanguage attributes.
     * @return array
     */
    private function getDynamicAttributes(): array
    {
        $languageList = $this->getShortLanguageList();
        $dynamicAttributes = [];
        foreach ($languageList as $language) {
            foreach ($this->dynamicFields as $fieldConditions) {
                $dynamicAttributes[] = $fieldConditions['name'] . '_' . $language;
            }
        }
        return array_values($dynamicAttributes);
    }

    /**
     * Creates validation rules for dynamic fields for all languages.
     * @return array
     */
    private function getDynamicValidationRules(): array
    {
        $rules = [];
        foreach ($this->getShortLanguageList() as $language) {
            foreach ($this->dynamicFields as $fieldConditions) {

                $fieldName = $fieldConditions['name'];
                $fieldRules = isset($fieldConditions['rules']) ? $fieldConditions['rules'] : [];

                foreach ($fieldRules as $fieldRule) {

                    if (in_array('required', $fieldRule) && $language != Language::getDefaultLanguage()->shortName){
                        continue;
                    }

                    if (in_array('unique', $fieldRule)){
                        $fieldRule = ArrayHelper::merge(
                            $fieldRule,
                            [
                                'skipOnError'     => true,
                                'targetClass'     => $this->mainModel->getTranslateModelName(),
                                'targetAttribute' => [$fieldName . '_' . $language => $fieldName],
                                'filter' => $this->getScenario() == self::SCENARIO_UPDATE ? $this->mainModel->getKeyToMainModel().' != '.$this->id : '',
                                'message' => isset($fieldRule['message']) ? $fieldRule['message'] : 'Record with such attribute "{attribute}" already exists'
                            ]
                        );
                    }

                    $rules[] = ArrayHelper::merge(
                        [$fieldName . '_' . $language],
                        $fieldRule
                    );
                }
            }
        }

        return $rules;
    }

    /**
     * Returns the list of available languages in the short name format.
     * @return array
     */
    private function getShortLanguageList(): array
    {
        return Language::getShortLanguageList();
    }
}
