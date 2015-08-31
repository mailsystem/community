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
        self::table($schema);
        self::foreignKeys($schema);
    }

    /**
     * Generate table ms_email_campaign
     *
     * @param Schema $schema
     */
    public static function table(Schema $schema)
    {
        /** Generate table ms_email_campaign **/
        $table = $schema->createTable('ms_email_campaign');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('contact_group_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('is_sent', 'boolean', []);
        $table->addColumn('schedule', 'string', ['length' => 255]);
        $table->addColumn('scheduled_for', 'datetime', ['notnull' => false, 'comment' => '(DC2Type:datetime)']);
        $table->addColumn('sender_email', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('sender_name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('letter_id', 'integer', ['notnull' => false]);
        $table->addColumn('letter_template_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('updated_at', 'datetime', ['comment' => '(DC2Type:datetime)']);
        $table->addColumn('sent_at', 'datetime', ['notnull' => false, 'comment' => '(DC2Type:datetime)']);

        $table->addIndex(['contact_group_id'], 'idx_ms_cg_id', []);
        $table->addIndex(['owner_id'], 'idx_ms_ec_owner_id', []);
        $table->addIndex(['organization_id'], 'idx_ms_ec_organization_id', []);
        $table->addIndex(['letter_id'], 'idx_ms_ec_letter_id', []);
        $table->addIndex(['letter_template_id'], 'idx_ms_ec_letter_template_id', []);
        $table->setPrimaryKey(['id']);

        /** End of generate table ms_email_campaign **/
    }

    /**
     * Generate foreign keys for table ms_email_campaign
     *
     * @param Schema $schema
     */
    public static function foreignKeys(Schema $schema)
    {
        /** Generate foreign keys for table ms_email_campaign **/
        $table = $schema->getTable('ms_email_campaign');
        $table->addForeignKeyConstraint(
            $schema->getTable('orocrm_contact_group'),
            ['contact_group_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_user'),
            ['owner_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('oro_organization'),
            ['organization_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_letter'),
            ['letter_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_letter_template'),
            ['letter_template_id'],
            ['id'],
            ['onUpdate' => null, 'onDelete' => 'SET NULL']
        );
        /** End of generate foreign keys for table ms_email_campaign **/
    }
}
