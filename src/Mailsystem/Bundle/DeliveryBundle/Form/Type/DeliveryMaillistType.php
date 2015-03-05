<?php
namespace Mailsystem\Bundle\DeliveryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeliveryMaillistType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'owner',
                'oro_user_select',
                [
                    'required' => true,
                    'label' => 'magecore.demoactivity.demo.owner.label',
                    'attr' => [
                        'autofocus' => 'autofocus',
                        'tabindex' => '1'
                    ]
                ]
            )
            ->add(
                'calendarOwner',
                'oro_user_select',
                [
                    'required' => true,
                    'label' => 'magecore.demoactivity.demo.calendar_owner.label'
                ]
            )
            ->add(
                'demoDate',
                'oro_datetime',
                [
                    'required' => true,
                    'label' => 'magecore.demoactivity.demo.demo_date.label'
                ]
            )
            ->add(
                'participants',
                'textarea',
                [
                    'required' => false,
                    'label' => 'magecore.demoactivity.demo.participants.label'
                ]
            )
            ->add(
                'notes',
                'textarea',
                [
                    'required' => false,
                    'label' => 'magecore.demoactivity.demo.notes.label'
                ]
            )
            ->add(
                'reminders',
                'oro_reminder_collection',
                [
                    'property_path' => 'calendarEvent.reminders',
                    'required' => false,
                    'label' => 'oro.reminder.entity_plural_label'
                ]
            );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Mailsystem\Bundle\DeliveryBundle\Entity\DeliveryMaillist'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mailsystem_delivery_maillist_form';
    }
}
