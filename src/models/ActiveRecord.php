<?php

namespace Itstructure\AdminModule\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Itstructure\AdminModule\interfaces\ModelInterface;

/**
 * Class ActiveRecord
 *
 * @package Itstructure\AdminModule\models
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Connect behavior to the basic model.
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class'              => TimestampBehavior::class,
            'createdAtAttribute' => 'created_at',
            'updatedAtAttribute' => 'updated_at',
            'value'              => new Expression('NOW()'),
        ];
        return $behaviors;
    }

    /**
     * Scenarios.
     *
     * @return array
     */
    public function scenarios()
    {
        return [
            ModelInterface::SCENARIO_CREATE => $this->attributes(),
            ModelInterface::SCENARIO_UPDATE => $this->attributes(),
            self::SCENARIO_DEFAULT => $this->attributes(),
        ];
    }
}
