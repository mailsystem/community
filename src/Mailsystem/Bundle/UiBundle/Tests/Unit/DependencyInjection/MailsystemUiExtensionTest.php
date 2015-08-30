<?php

namespace Mailsystem\Bundle\UiBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;

use Mailsystem\Bundle\UiBundle\DependencyInjection\MailsystemUiExtension;

class MailsystemUiExtensionTest extends ExtensionTestCase
{
    public function testLoad()
    {
        $this->loadExtension(new MailsystemUiExtension());

        $expectedParameters = [
            'mailsystem_tinymce_type.class'
        ];
        $this->assertParametersLoaded($expectedParameters);

        $expectedDefinitions = [
            'base.form.type.tinymce'
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);
    }
}
