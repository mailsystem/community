<?php

namespace Mailsystem\Bundle\LetterBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class LetterType
 *
 * @package Mailsystem\Bundle\LetterBundle\Form\Type
 */
class LetterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mailsystem_letter_request';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'subject',
            'text',
            [
                'required'        => true,
                'label'           => 'mailsystem.letter.subject.label',
                'attr'=>[
                    'style' => 'width: 177%;'
                ]
            ]
        );
        $builder->add(
            'body',
            'tinymce',
            [
                'required' => true,
                'label'    => 'mailsystem.letter.body.label',
            ]
        );
        $builder->add(
            'submit',
            'submit',
            [
                'label' => 'mailsystem.letter.submit.label',
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
                'data_class' => 'Mailsystem\Bundle\LetterBundle\Entity\Letter',
            ]
        );
    }
}
