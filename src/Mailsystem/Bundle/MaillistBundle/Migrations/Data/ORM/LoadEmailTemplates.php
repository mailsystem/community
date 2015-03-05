<?php

namespace Mailsystem\Bundle\MaillistBundle\Migrations\Data\ORM;

use Oro\Bundle\EmailBundle\Migrations\Data\ORM\AbstractEmailFixture;

/**
 * Class LoadEmailTemplates
 *
 * @package Mailsystem\Bundle\MaillistBundle\Migrations\Data\ORM
 */
class LoadEmailTemplates extends AbstractEmailFixture
{
    /**
     * Return path to email templates
     *
     * @return string
     */
    public function getEmailsDir()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'data/emails';
    }
}
