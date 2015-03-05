<?php

namespace Mailsystem\Bundle\MaillistBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class MailsystemMaillistBundle implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::mailsystemMaillistTable($schema);
        self::mailsystemMaillistForeignKeys($schema);
    }

    /**
     * Generate table mailsystem_maillist
     *
     * @param Schema $schema
     */
    public static function mailsystemMaillistTable(Schema $schema)
    {
        /** Generate table mailsystem_maillist **/
        $table = $schema->createTable('mailsystem_maillist');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', [
            'notnull' => false,
            'oro_options' => [
                'dataaudit' => [
                    'auditable' => true
                ]
            ]
        ]);
        $table->addColumn('organization_id', 'integer', [
            'notnull' => false,
            'oro_options' => [
                'dataaudit' => [
                    'auditable' => true
                ]
            ]
        ]);
        $table->addColumn('name', 'string', ['notnull' => true, 'length' => 255,
            'oro_options' => [
                'dataaudit' => [
                    'auditable' => true
                ]
            ]]);
        $table->addColumn('description', 'text', ['notnull' => false,
            'oro_options' => [
                'dataaudit' => [
                    'auditable' => true
                ]
            ]]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_MAILSYSTEM_MAILLIST_OWNER', []);
        $table->addIndex(['organization_id'], 'IDX_MAILSYSTEM_MAILLIST_ORGANIZATION', []);
        /** End of generate table mailsystem_maillist **/
    }

    /**
     * Generate foreign keys for table mailsystem_maillist
     *
     * @param Schema $schema
     */
    public static function mailsystemMaillistForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table mailsystem_maillist **/
        $table = $schema->getTable('mailsystem_maillist');
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
        /** End of generate foreign keys for table mailsystem_maillist **/
    }
}
