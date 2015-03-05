<?php

namespace Mailsystem\Bundle\DeliveryBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class MailsystemDeliveryBundle implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::mailsystemDeliveryMaillistTable($schema);
        self::mailsystemDeliveryMaillistForeignKeys($schema);
    }

    /**
     * Generate table mailsystem_delivery_maillist
     *
     * @param Schema $schema
     */
    public static function mailsystemDeliveryMaillistTable(Schema $schema)
    {
        /** Generate table mailsystem_delivery_maillist **/
        $table = $schema->createTable('mailsystem_delivery_maillist');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn(
            'user_owner_id',
            'integer',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => false
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
                        'auditable' => false
                    ]
                ]
            ]
        );
        $table->addColumn(
            'letter_template_id',
            'integer',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => false
                    ]
                ]
            ]
        );
        $table->addColumn(
            'maillist_id',
            'integer',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => false
                    ]
                ]
            ]
        );
        $table->addColumn(
            'notes',
            'text',
            [
                'notnull' => false,
                'oro_options' => [
                    'dataaudit' => [
                        'auditable' => false
                    ]
                ]
            ]
        );
        $table->addColumn('created_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_MAILSYSTEM_DELIVERY_MAILLIST_OWNER', []);
        $table->addIndex(['organization_id'], 'IDX_MAILSYSTEM_DELIVERY_MAILLIST_ORGANIZATION', []);
        /** End of generate table mailsystem_delivery_maillist **/
    }

    /**
     * Generate foreign keys for table mailsystem_delivery_maillist
     *
     * @param Schema $schema
     */
    public static function mailsystemDeliveryMaillistForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table mailsystem_letter **/
        $table = $schema->getTable('mailsystem_delivery_maillist');
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
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_letter_template'),
            ['letter_template_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_maillist'),
            ['maillist_id'],
            ['id'],
            ['onDelete' => 'SET NULL', 'onUpdate' => null]
        );
        /** End of generate foreign keys for table mailsystem_delivery_maillist **/
    }
}
