<?php

namespace Mailsystem\Bundle\RecipientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class RecipientType
 *
 * @package Mailsystem\Bundle\RecipientBundle\Form\Type
 */
class RecipientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mailsystem_recipient_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'first_name',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.first_name.label'
            ]
        );
        $builder->add(
            'last_name',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.last_name.label'
            ]
        );
        $builder->add(
            'email',
            'text',
            [
                'required' => true,
                'label'    => 'mailsystem.recipient.email.label'
            ]
        );
        $builder->add(
            'phone',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.phone.label'
            ]
        );
        $builder->add(
            'skype',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.skype.label'
            ]
        );
        $builder->add(
            'position',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.position.label'
            ]
        );
        $builder->add(
            'company',
            'text',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.company.label'
            ]
        );
        $builder->add(
            'birth_date',
            'oro_date',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.birth_date.label'
            ]
        );
        $builder->add(
            'description',
            'textarea',
            [
                'required' => false,
                'label'    => 'mailsystem.recipient.description.label'
            ]
        );
        $builder->add(
            'maillists',
            null,
            [
                'required' => false,
            ]
        );
        $builder->add(
            'submit',
            'submit',
            [
                'label' => 'mailsystem.recipient.submit.label'
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
                'data_class' => 'Mailsystem\Bundle\RecipientBundle\Entity\Recipient',
            ]
        );
    }
}
