<?php

namespace Mailsystem\Bundle\RecipientBundle\ImportExport\TemplateFixture;

use Oro\Bundle\ImportExportBundle\TemplateFixture\AbstractTemplateRepository;
use Oro\Bundle\ImportExportBundle\TemplateFixture\TemplateFixtureInterface;

use Mailsystem\Bundle\RecipientBundle\Entity\Recipient;

class RecipientFixture extends AbstractTemplateRepository implements TemplateFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    public function getEntityClass()
    {
        return 'Mailsystem\Bundle\RecipientBundle\Entity\Recipient';
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->getEntityData('Jerry Coleman');
    }

    /**
     * {@inheritdoc}
     */
    protected function createEntity($key)
    {
        return new Recipient();
    }

    /**
     * @param string $key
     * @param Recipient $entity
     */
    public function fillEntityData($key, $entity)
    {
        switch ($key) {
            case 'Jerry Coleman':
                $entity->setFirstName('Jerry');
                $entity->setLastName('Coleman');
                $entity->setEmail('jerry@coleman.name');
                $entity->setPhone('123456789');
                $entity->setSkype('jerry.coleman');
                $entity->setPosition('man');
                $entity->setCompany('company');
                $entity->setBirthDate(new \DateTime());
                $entity->setDescription('description');

                return;
                break;
        }
        parent::fillEntityData($key, $entity);
    }
}
