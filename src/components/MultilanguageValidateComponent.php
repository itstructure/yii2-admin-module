<?php

namespace Itstructure\AdminModule\components;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecordInterface;
use yii\base\{Component, InvalidConfigException};
use Itstructure\AdminModule\{
    models\MultilanguageValidateModel,
    interfaces\ModelInterface,
    interfaces\ValidateComponentInterface
};

/**
 * Class MultilanguageValidateComponent
 * Component class for validation multilanguage fields.
 *
 * @property array $models Array of models with multilanguage fields.
 *
 * @package Itstructure\AdminModule\components
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class MultilanguageValidateComponent extends Component implements ValidateComponentInterface
{
    /**
     * Array of models with multilanguage fields.
     *
     * @var array
     */
    public $models = [];

    /**
     * Sets a specific model for the general validation model.
     *
     * @param ActiveRecordInterface $mainModel
     *
     * @throws InvalidConfigException
     *
     * @return ModelInterface
     */
    public function setModel(ActiveRecordInterface $mainModel): ModelInterface
    {
        $config = $this->models[$mainModel::tableName()];

        if (!is_array($config['dynamicFields'])) {
            throw new InvalidConfigException('No dynamic fields are specified.');
        }

        /** @var ModelInterface $object */
        $object = Yii::createObject(ArrayHelper::merge(
            [
                'class' => MultilanguageValidateModel::class,
                'mainModel' => $mainModel,
            ], $config)
        );

        return $object;
    }
}
