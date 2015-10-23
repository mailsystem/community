<?php

namespace Mailsystem\Bundle\DeliveryBundle\Command;

use Doctrine\ORM\EntityManager;
use Mailsystem\Bundle\LetterBundle\Entity\Letter;
use Oro\Bundle\EmailBundle\Model\EmailRecipientsProviderArgs;
use OroCRM\Bundle\ContactBundle\Entity\Group as ContactGroup;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ContactGroupCommand extends CommandAbstract
{
    /** @var  EntityManagerr */
    protected $em;
    /** @var  \Swift_Mailer */
    protected $mailer;

    protected function getCommandName()
    {
        return 'contact-group';
    }

    protected function getCommandDescription()
    {
        return 'Sending Email to Contact Group';
    }

    public function configure()
    {
        parent::configure();

        $this->addArgument(
            'letter',
            InputArgument::REQUIRED,
            'Letter Id'
        );
        $this->addArgument(
            'contact-group',
            InputArgument::REQUIRED,
            'Contact Group Id'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $letterId       = $input->getArgument('letter');
        $contactGroupId = $input->getArgument('contact-group');

        $input->validate();

        $this->em     = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->mailer = $this->getContainer()->get('mailer');
        /** @var Letter $letter */
        $letter = $this->em->getRepository('MailsystemLetterBundle:Letter')->find($letterId);
        $output->writeln(sprintf('Letter : %s', $letter->getSubject()));
        /** @var ContactGroup $contactGroup */
        $contactGroup = $this->em->getRepository('OroCRMContactBundle:Group')->find($contactGroupId);
        $output->writeln(sprintf('Contact Group : %s', $contactGroup->getLabel()));
        $this->sendEmail($letter, $contactGroup);
    }

    protected function sendEmail(Letter $letter, ContactGroup $contactGroup)
    {
        $provider = $this->getContainer()->get('orocrm_contact.provider.email_recipients');
        print_r($contactGroup->getLabel());
        $args = new EmailRecipientsProviderArgs($contactGroup, null, 2);
        print_r($provider->getRecipients($args));

        exit;
        $message = \Swift_Message::newInstance()
            ->setSubject($letter->getSubject())
            ->setFrom('vladimir@drizheruk.com.ua', 'Vladimir Drizheruk')
            ->setTo('vladimir@drizheruk.com.ua')
            ->setBody($letter->getBody(), 'text/html');

        $this->mailer->send($message);
    }
}
