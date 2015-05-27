<?php

namespace Mailsystem\Bundle\LetterBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

use Oro\Bundle\AttachmentBundle\Migration\Extension\AttachmentExtension;
use Oro\Bundle\AttachmentBundle\Migration\Extension\AttachmentExtensionAwareInterface;

class MailsystemLetterBundle implements Migration, AttachmentExtensionAwareInterface
{
    /** @var AttachmentExtension */
    protected $attachmentExtension;

    /**
     * {@inheritdoc}
     */
    public function setAttachmentExtension(AttachmentExtension $attachmentExtension)
    {
        $this->attachmentExtension = $attachmentExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->attachmentExtension->addAttachmentAssociation(
            $schema,
            'mailsystem_letter', // entity table, e.g. oro_user, orocrm_contact etc.
            [], // optional, allowed MIME types of attached files, if empty - global configuration will be used
            2 // optional, max allowed file size in megabytes, by default 1 Mb
        );
    }
}
