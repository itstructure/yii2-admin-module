<?php

namespace Itstructure\AdminModule\components;

use yii\helpers\ArrayHelper;

/**
 * Class MultilanguageMigration
 * Class to extend migration with multilanguage.
 *
 * @package Itstructure\AdminModule\components
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class MultilanguageMigration extends \yii\db\Migration
{
    /**
     * Postfix for translate table name.
     */
    const TRANSLATE_TABLE_POSTFIX = 'language';

    /**
     * Table name to contain the project languages.
     */
    const LANGUAGE_TABLE_NAME = 'language';

    /**
     * Creates table with timestamp fields: created_at and updated_at.
     * @param string $table - table name.
     * @param array $columns - array with names and types of columns.
     * @param null   $options - additional SQL code.
     * @return void
     */
    public function createTableWithTimestamps(string $table, array $columns, $options = null): void
    {
        $columns = ArrayHelper::merge($columns, [
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->createTable($table, $columns, $options);
    }

    /**
     * Creates two tables: main table and translate table.
     * For example:
     * catalog:
     *  - id
     *  - created_at
     *  - updated_at
     *
     * catalog_language:
     *  - catalog_id
     *  - language_id
     *  - title
     *  - text
     * @param string $table - table name which needs to be translated.
     * @param array  $multiLanguageColumns - list of multilanguage fields.
     * @param array  $columns - list of simple fields.
     * @param string $options - additional SQL code.
     * @return void
     */
    public function createMultiLanguageTable(string $table, array $multiLanguageColumns, array$columns = [], $options = null): void
    {
        $this->createTableWithTimestamps($table,
            ArrayHelper::merge(['id' => $this->primaryKey()], $columns)
        );

        $keyToPrimaryTable = $this->getKeyToPrimaryTable($table);
        $keyToLanguageTable = self::getKeyToLanguageTable();

        $languageTableKeys = [
            $keyToPrimaryTable => $this->integer(),
            $keyToLanguageTable => $this->integer(),
            "PRIMARY KEY($keyToPrimaryTable, $keyToLanguageTable)",
        ];

        $translateTableName = $this->getTranslateTableName($table);

        $this->createTableWithTimestamps($translateTableName, ArrayHelper::merge($languageTableKeys, $multiLanguageColumns), $options);

        $this->addForeignKey(
            $this->createFkName($translateTableName, $keyToPrimaryTable),
            $translateTableName,
            $keyToPrimaryTable,
            $table,
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->createFkName($translateTableName, $keyToLanguageTable),
            $translateTableName,
            $keyToLanguageTable,
            self::LANGUAGE_TABLE_NAME,
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Drop main table with translate table.
     * @param string $table - main table name.
     * @return void
     */
    public function dropMultiLanguageTable(string $table): void
    {
        $translateTableName = $this->getTranslateTableName($table);

        $foreignKeyToPrimary = $this->createFkName($translateTableName, $this->getKeyToPrimaryTable($table));
        $foreignKeyToLanguage = $this->createFkName($translateTableName, self::getKeyToLanguageTable());

        $this->dropForeignKey($foreignKeyToPrimary, $translateTableName);
        $this->dropForeignKey($foreignKeyToLanguage, $translateTableName);

        $this->dropTable($translateTableName);
        $this->dropTable($table);
    }

    /**
     * Returns key name for link translate table with languages table.
     * @return string
     */
    public static function getKeyToLanguageTable(): string
    {
        return self::LANGUAGE_TABLE_NAME . '_id';
    }

    /**
     * Returns foreign key to other table.
     * @param string $table
     * @param string $column
     * @return string
     */
    private function createFkName(string $table, string $column): string
    {
        return 'fk-' . $table . '-' . $column;
    }

    /**
     * Returns table name for translates.
     * @param string $table - main table name.
     * @return string
     */
    private function getTranslateTableName(string $table): string
    {
        return $table . '_' . self::TRANSLATE_TABLE_POSTFIX;
    }

    /**
     * Returns key name for link translate table with main table.
     * @param string $table - main table name.
     * @return string
     */
    private function getKeyToPrimaryTable(string $table): string
    {
        return $table . '_id';
    }
}
