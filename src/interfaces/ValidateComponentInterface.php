<?php

namespace Itstructure\AdminModule\interfaces;

use yii\db\ActiveRecordInterface;

/**
 * Interface ValidateComponentInterface
 *
 * @package Itstructure\AdminModule\interfaces
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
interface ValidateComponentInterface
{
    /**
     * Search model data.
     *
     * @param $model ActiveRecordInterface
     *
     * @return ModelInterface
     */
    public function setModel(ActiveRecordInterface $model): ModelInterface;
}
