<?php

namespace Itstructure\AdminModule\models;

use Itstructure\AdminModule\Module;
use Itstructure\AdminModule\interfaces\ModelInterface;
use Itstructure\FieldWidgets\interfaces\{LanguageListInterface, LanguageFieldInterface};

/**
 * This is the model class for table "language".
 *
 * @property int    $id
 * @property string $shortName
 * @property string $name
 * @property string $locale
 * @property int    $default
 * @property string $created_at
 * @property string $updated_at
 *
 * @package Itstructure\AdminModule\models
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class Language extends ActiveRecord implements LanguageListInterface, LanguageFieldInterface, ModelInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['default'],
                'integer',
            ],
            [
                [
                    'created_at',
                    'updated_at',
                ],
                'safe',
            ],
			[
                [
                    'locale',
                    'shortName',
                    'name',
                ],

                'required',
            ],
            [
                'locale',
                'string',
                'max' => 8,
            ],
            [
                'shortName',
                'string',
                'max' => 3,
            ],
            [
                'name',
                'string',
                'max' => 64,
            ],
            [
                'locale',
                'unique',
                'skipOnError'   => true,
                'targetClass'   => static::class,
                'filter'        => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
            ],
            [
                'shortName',
                'unique',
                'skipOnError'   => true,
                'targetClass'   => static::class,
                'filter'        => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
            ],
            [
                'name',
                'unique',
                'skipOnError'   => true,
                'targetClass'   => static::class,
                'filter'        => $this->getScenario() == self::SCENARIO_UPDATE ? 'id != '.$this->id : ''
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Module::t('main', 'ID'),
            'shortName'  => Module::t('languages', 'Short name'),
            'name'       => Module::t('languages', 'Language name'),
            'locale'     => Module::t('languages', 'Locale'),
            'default'    => Module::t('languages', 'Set this language as default'),
            'created_at' => Module::t('main', 'Created date'),
            'updated_at' => Module::t('main', 'Updated date'),
        ];
    }

    /**
     * Reset the default language.
     *
     * @param boolean $insert
     *
     * @return mixed
     */
    public function beforeSave($insert)
    {
        if ($this->default == 1) {

            $default = static::findOne([
                'default' => 1,
            ]);

            if (null !== $default){
                $default->default = 0;
                $default->save();
            }
        }

        return parent::beforeSave($insert);
    }

    /**
     * Returns the default language.
     *
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getDefaultLanguage()
    {
        return static::find()
            ->where([
                'default' => 1
            ])
            ->one();
    }

    /**
     * List of available languages in short name format.
     *
     * @return array
     */
    public static function getShortLanguageList(): array
    {
        $result = static::find()->all();
        return array_map(function(Language $item) {
            return $item->shortName;
        }, $result);
    }

    /**
     * Returns a list of available languages in the system.
     *
     * @return Language[]
     */
    public function getLanguageList(): array
    {
        return static::find()->all();
    }

    /**
     * Returns the full name of the language.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the short name of the language.
     *
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * Returns default mode.
     *
     * @return int
     */
    public function getDefault(): int
    {
        return $this->default;
    }

    /**
     * Returns current model id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
