<?php

namespace Mailsystem\Bundle\LetterBundle\Form\Type;

use Oro\Bundle\EmbeddedFormBundle\Form\Type\CustomLayoutFormInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LetterTemplateType
 *
 * @package Mailsystem\Bundle\LetterBundle\Form\Type
 */
class LetterTemplateType extends AbstractType implements CustomLayoutFormInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mailsystem_letter_template_request';
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
                'label' => 'mailsystem.letter_template.name.label'
            ]
        );
        $builder->add(
            'body',
            'textarea',
            [
                'required' => true,
                'label' => 'mailsystem.letter_template.body.label'
            ]
        );
        $builder->add(
            'submit',
            'submit',
            [
                'label' => 'mailsystem.letter_template.submit.label'
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
                'data_class' => 'Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate',
            ]
        );
    }

    /**
     * @return string
     */
    public function getFormLayout()
    {
        return 'MailsystemLetterBundle:LetterTemplate:form.html.twig';
    }
}
