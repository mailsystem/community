<?php

namespace Mailsystem\Bundle\LetterBundle\Migrations\Schema\v1_0;

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
        self::mailsystemLetterTable($schema);
        self::mailsystemLetterForeignKeys($schema);
    }

    /**
     * Generate table mailsystem_letter
     *
     * @param Schema $schema
     */
    public static function mailsystemLetterTable(Schema $schema)
    {
        /** Generate table mailsystem_letter **/
        $table = $schema->createTable('mailsystem_letter');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn(
            'user_owner_id',
            'integer',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => true
                    ]
                ]
            ]
        );
        $table->addColumn(
            'organization_id',
            'integer',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => true
                    ]
                ]
            ]
        );
        $table->addColumn(
            'subject',
            'string',
            [
                'notnull' => true,
                'length' => 255,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => true
                    ]
                ]
            ]
        );
        $table->addColumn(
            'body',
            'text',
            [
                'notnull' => true,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => true
                    ]
                ]
            ]
        );
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_MAILSYSTEM_LETTER_OWNER', []);
        $table->addIndex(['organization_id'], 'IDX_MAILSYSTEM_LETTER_ORGANIZATION', []);
        /** End of generate table mailsystem_letter **/
    }

    /**
     * Generate foreign keys for table mailsystem_letter
     *
     * @param Schema $schema
     */
    public static function mailsystemLetterForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table mailsystem_letter **/
        $table = $schema->getTable('mailsystem_letter');
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
        /** End of generate foreign keys for table mailsystem_letter **/
    }
}
