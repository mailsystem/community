<?php
namespace Mailsystem\Bundle\LetterBundle\Tests\Unit\Entity;

use Mailsystem\Bundle\LetterBundle\Entity\Letter;

class LetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetDataProvider
     */
    public function testGetSet($property, $value, $expected)
    {
        $obj = new Letter();

        call_user_func_array([$obj, 'set' . ucfirst($property)], [$value]);
        $this->assertEquals($expected, call_user_func_array([$obj, 'get' . ucfirst($property)], []));
    }

    public function getSetDataProvider()
    {
        $now = new \DateTime('now');

        $owner = $this->getMockBuilder('Oro\Bundle\UserBundle\Entity\User')
            ->disableOriginalConstructor()
            ->getMock();

        $organization = $this->getMockBuilder('Oro\Bundle\OrganizationBundle\Entity\Organization')
            ->disableOriginalConstructor()
            ->getMock();

        return [
            'owner' => ['owner', $owner, $owner],
            'organization' => ['organization', $organization, $organization],
            'subject' => ['subject', 'subject', 'subject'],
            'body' => ['body', 'body', 'body'],
            'createdAt' => ['createdAt', $now, $now],
            'updatedAt' => ['updatedAt', $now, $now],
        ];
    }

    public function testBeforeSave()
    {
        $obj = new Letter();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
    }

    public function testBeforeUpdate()
    {
        $obj = new Letter();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->preUpdate();

        $this->assertInstanceOf('\DateTime', $obj->getUpdatedAt());
        $this->assertNull($obj->getCreatedAt());
    }
}
