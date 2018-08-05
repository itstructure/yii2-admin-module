<?php

namespace Itstructure\AdminModule\interfaces;

/**
 * Interface ModelInterface
 *
 * @package Itstructure\AdminModule\interfaces
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
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
     * @param null $formName
     *
     * @return bool
     */
    public function load($data, $formName = null);

    /**
     * Sets the attribute values in a massive way.
     * Used from the parent model yii\base\Model.
     *
     * @param array $values attribute values (name => value) to be assigned to the model.
     * @param bool $safeOnly whether the assignments should only be done to the safe attributes.
     */
    public function setAttributes($values, $safeOnly = true);
}
