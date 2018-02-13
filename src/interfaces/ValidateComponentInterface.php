<?php

namespace Itstructure\AdminModule\interfaces;

use yii\db\ActiveRecordInterface;

/**
 * Interface ValidateComponentInterface
 *
 * @package Itstructure\AdminModule\interfaces
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
