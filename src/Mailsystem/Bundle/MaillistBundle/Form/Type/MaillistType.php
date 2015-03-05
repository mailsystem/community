<?php

namespace Mailsystem\Bundle\MaillistBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class MaillistType
 *
 * @package Mailsystem\Bundle\MaillistBundle\Form\Type
 */
class MaillistType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mailsystem_maillist_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'name',
            'text',
            [
                'required' => true,
                'label'    => 'mailsystem.maillist.name.label'
            ]
        );
        $builder->add(
            'description',
            'textarea',
            [
                'required' => false,
                'label'    => 'mailsystem.maillist.description.label'
            ]
        );
        $builder->add(
            'submit',
            'submit',
            [
                'label' => 'mailsystem.maillist.submit.label'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Mailsystem\Bundle\MaillistBundle\Entity\Maillist',
            ]
        );
    }
}
