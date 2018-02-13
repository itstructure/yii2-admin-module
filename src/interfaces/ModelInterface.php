<?php

namespace Itstructure\AdminModule\interfaces;

/**
 * Interface ModelInterface
 *
 * @package Itstructure\AdminModule\interfaces
 */
interface ModelInterface
{
    /**
     * Save data.
     *
     * @return bool
     */
    public function save();

    /**
     * Returns current model id.
     *
     * @return int|string
     */
    public function getId();

    /**
     * Load data.
     * Used from the parent model yii\base\Model.
     *
     * @param $data
     *
     * @param null $formName
     *
     * @return bool
     */
    public function load($data, $formName = null);
}
