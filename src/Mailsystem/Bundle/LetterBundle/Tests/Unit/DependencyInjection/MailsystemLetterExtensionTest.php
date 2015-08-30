<?php

namespace Mailsystem\Bundle\LetterBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;

use Mailsystem\Bundle\LetterBundle\DependencyInjection\MailsystemLetterExtension;

class MailsystemLetterExtensionTest extends ExtensionTestCase
{
    public function testLoad()
    {
        $this->loadExtension(new MailsystemLetterExtension());

        $expectedParameters = [
            'mailsystem_letter.entity.class',
            'mailsystem_letter_template.entity.class',
            'mailsystem_letter_form.class',
            'mailsystem_letter_template_form.class',
            'mailsystem_letter.form.handler.class',
            'mailsystem_letter_template.form.handler.class'
        ];
        $this->assertParametersLoaded($expectedParameters);

        $expectedDefinitions = [
            'mailsystem_letter_embedded_form',
            'mailsystem_letter_template_embedded_form',
            'mailsystem_letter.form',
            'mailsystem_letter_template.form',
            'mailsystem_letter.form.handler',
            'mailsystem_letter_template.form.handler'
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);
    }
}
