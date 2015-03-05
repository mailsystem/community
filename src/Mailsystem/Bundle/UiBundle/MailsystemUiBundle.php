<?php
/**
 * File : MailsystemUiBundle.php
 */
namespace Mailsystem\Bundle\UiBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Mailsystem\Bundle\UiBundle\DependencyInjection\Compiler\FormCompilerPass;

/**
 * Class MailsystemUiBundle
 *
 * @package Mailsystem\Bundle\UiBundle
 */
class MailsystemUiBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormCompilerPass());
    }
}
