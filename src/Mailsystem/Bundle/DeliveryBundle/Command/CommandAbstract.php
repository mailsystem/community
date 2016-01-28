<?php
namespace Mailsystem\Bundle\DeliveryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class CommandAbstract extends ContainerAwareCommand
{
    const COMMAND_NAME_PREFIX = 'mailsystem:delivery';

    abstract protected function getCommandName();
    abstract protected function getCommandDescription();

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME_PREFIX . ':' . $this->getCommandName());
        $this->setDescription($this->getCommandDescription());
    }
}
