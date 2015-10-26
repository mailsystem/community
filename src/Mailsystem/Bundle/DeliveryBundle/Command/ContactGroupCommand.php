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

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->mailer = $this->getContainer()->get('mailer');
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
        $this->addArgument(
            'send_from_email',
            InputArgument:REQUIRED,
            'Sender email'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $letterId = $input->getArgument('letter');
        $contactGroupId = $input->getArgument('contact-group');

        $input->validate();

        /** @var Letter $letter */
        $letter = $this->em->getRepository('MailsystemLetterBundle:Letter')->find($letterId);
        $output->writeln(sprintf('Letter : %s', $letter->getSubject()));
        /** @var ContactGroup $contactGroup */
        $contactGroup = $this->em->getRepository('OroCRMContactBundle:Group')->find($contactGroupId);
        $output->writeln(sprintf('Contact Group : %s', $contactGroup->getLabel()));
        $this->sendEmail($letter, $contactGroup, function ($data) {
            $output->writeln($data);
        });
    }

    protected function sendEmail(Letter $letter, ContactGroup $contactGroup, $callback = null)
    {
        $stmt = $this->em
            ->getConnection()
            ->prepare('select contact_id from  orocrm_contact_to_contact_grp where contact_group_id = :group_id');
        $stmt->bindValue(':group_id', $contactGroup->getId());
        $stmt->execute();
        $contactIds = $stmt->fetchAll();
        if (!count($contactIds)) {
            echo sprintf('No Contacts Found in Group %s', $contactGroup->getLabel());
            exit;
        }
        foreach ($contactIds as $contactId) {
            $contact = $this->em->getRepository('OroCRMContactBundle:Contact')->find($contactId['contact_id']);
            $email = $contact->getEmail();

            $message = \Swift_Message::newInstance()
                ->setSubject($letter->getSubject())
                ->setFrom('vladimir@drizheruk.com.ua', 'Vladimir Drizheruk')
                ->setTo('vladimir@drizheruk.com.ua')
                ->setBody($letter->getBody(), 'text/html');
            if ($this->mailer->send($message)) {
                echo sprintf("Send to %s", $email) . PHP_EOL . PHP_EOL;
            }
            unset($email);
            unset($message);
        }
    }
}
