<?php

namespace Mailsystem\Bundle\UiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Class TinymceType
 *
 * @package Mailsystem\Bundle\UiBundle\Form\Type
 */
class TinymceType extends AbstractType
{
    public function getParent()
    {
        return 'textarea';
    }

    public function getName()
    {
        return 'tinymce';
    }
}
