<?php

use Itstructure\AdminModule\components\MultilanguageMigration;
use Itstructure\AdminModule\models\Language;

/**
 * Handles the creation of table `language`.
 */
class m171202_104405_create_language_table extends MultilanguageMigration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTableWithTimestamps(Language::tableName(), [
            'id' => $this->primaryKey(),
            'locale' => $this->string(),
            'shortName' => $this->string(),
            'name' => $this->string(),
            'default' => $this->boolean()
                ->notNull()
                ->defaultValue(0),
        ]);
        $now = (new \DateTime())->format('Y-m-d H:i:s');
        $this->db->createCommand()
            ->insert(Language::tableName(), [
                'locale' => 'en-EN',
                'shortName' => 'en',
                'name' => 'English',
                'default' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->execute();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(Language::tableName());
    }
}
