<?php

namespace Mailsystem\Bundle\RecipientBundle\Migrations\Schema\v1_0;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * Class MailsystemRecipientBundle
 *
 * @package Mailsystem\Bundle\RecipientBundle\Migrations\Schema\v1_0
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class MailsystemRecipientBundle implements Migration
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        self::mailsystemRecipientTable($schema);
        self::mailsystemMaillistRecipientTable($schema);
        self::mailsystemRecipientForeignKeys($schema);
        self::mailsystemMaillistRecipientForeignKeys($schema);
    }

    /**
     * Generate table mailsystem_recipient
     *
     * @param Schema $schema
     */
    public static function mailsystemRecipientTable(Schema $schema)
    {
        /** Generate table mailsystem_recipient **/
        $table = $schema->createTable('mailsystem_recipient');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('first_name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('last_name', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('email', 'string', ['notnull' => true, 'length' => 255]);
        $table->addColumn('phone', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('skype', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('position', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('company', 'string', ['notnull' => false, 'length' => 255]);
        $table->addColumn('birth_date', 'date', ['notnull' => false]);
        $table->addColumn('description', 'text', ['notnull' => false]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', ['notnull' => false]);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['user_owner_id'], 'IDX_MS_RECIPIENT_OWNER', []);
        $table->addIndex(['organization_id'], 'IDX_MS_RECIPIENT_ORGANIZATION', []);
        /** End of generate table mailsystem_recipient **/
    }

    /**
     * Generate table mailsystem_maillist_recipient
     *
     * @param Schema $schema
     */
    public static function mailsystemMaillistRecipientTable(Schema $schema)
    {
        /** Generate table mailsystem_maillist_recipient **/
        $table = $schema->createTable('mailsystem_maillist_recipient');
        $table->addColumn('maillist_id', 'integer', ['notnull' => true]);
        $table->addColumn('recipient_id', 'integer', ['notnull' => true]);
        $table->setPrimaryKey(['maillist_id', 'recipient_id']);
        /** End of generate table mailsystem_maillist_recipient **/
    }

    /**
     * Generate foreign keys for table mailsystem_recipient
     *
     * @param Schema $schema
     */
    public static function mailsystemRecipientForeignKeys(Schema $schema)
    {
        /** Generate foreign keys for table mailsystem_recipient **/
        $table = $schema->getTable('mailsystem_recipient');
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
        /** End of generate foreign keys for table mailsystem_recipient **/
    }

    /**
     * Generate foreign keys for table mailsystem_maillist_recipient
     *
     * @param Schema $schema
     */
    public static function mailsystemMaillistRecipientForeignKeys(
        Schema $schema
    )
    {
        /** Generate foreign keys for table mailsystem_maillist_recipient **/
        $table = $schema->getTable('mailsystem_maillist_recipient');
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_recipient'),
            ['recipient_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        $table->addForeignKeyConstraint(
            $schema->getTable('mailsystem_maillist'),
            ['maillist_id'],
            ['id'],
            ['onDelete' => null, 'onUpdate' => null]
        );
        /** End of generate foreign keys for table mailsystem_recipient **/
    }
}
