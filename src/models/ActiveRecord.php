<?php

namespace Itstructure\AdminModule\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Class ActiveRecord
 *
 * @package app\components\db
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
}
