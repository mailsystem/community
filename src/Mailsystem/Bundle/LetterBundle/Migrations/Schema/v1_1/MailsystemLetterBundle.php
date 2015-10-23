<?php

namespace Mailsystem\Bundle\LetterBundle\Migrations\Schema\v1_1;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class MailsystemLetterBundle implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::msLetterTemplateTable($schema);
        self::msLetterTemplateForeignKeys($schema);
    }

    /**
     * Generate table ms_letter_template
     *
     * @param Schema $schema
     */
    public static function msLetterTemplateTable(Schema $schema)
    {
        /** Generate table ms_letter_template **/
        $table = $schema->createTable('ms_letter_template');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('body', 'text', ['notnull' => true]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_MS_LETTER_TEMPLATE_OWNER', []);
        $table->addIndex(['organization_id'], 'IDX_MS_LETTER_TEMPLATE_ORGANIZATION', []);
        /** End of generate table ms_letter_template **/
    }

    /**
     * Generate foreign keys for table ms_letter_template
     *
     * @param Schema $schema
     */
    public static function msLetterTemplateForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table ms_letter_template **/
        $table = $schema->getTable('ms_letter_template');
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['user_owner_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        /** End of generate foreign keys for table ms_letter_template **/
    }
}
