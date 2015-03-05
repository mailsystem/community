<?php

namespace Mailsystem\Bundle\UiBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class FormCompilerPass
 *
 * @package Mailsystem\Bundle\UiBundle\DependencyInjection\Compiler
 */
class FormCompilerPass implements CompilerPassInterface
{
    /**
     * Form Layout
     */
    const MAILSYSTEM_FORM_LAYOUT = 'MailsystemUiBundle:Form:fields.html.twig';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $allResources    = $container->getParameter('twig.form.resources');
        $resultResources = $allResources;
        if (!in_array(self::MAILSYSTEM_FORM_LAYOUT, $allResources)) {
            $resultResources[] = self::MAILSYSTEM_FORM_LAYOUT;

        }
        $container->setParameter('twig.form.resources', $resultResources);
    }
}
