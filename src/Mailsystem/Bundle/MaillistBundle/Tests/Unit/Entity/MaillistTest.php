<?php
namespace Mailsystem\Bundle\MaillistBundle\Tests\Unit\Entity;

use Mailsystem\Bundle\MaillistBundle\Entity\Maillist;

class MaillistTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetDataProvider
     */
    public function testGetSet($property, $value, $expected)
    {
        $obj = new Maillist();

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
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
            'name' => ['name', 'name', 'name'],
            'description' => ['description', 'description', 'description'],
            'createdAt' => ['createdAt', $now, $now],
            'updatedAt' => ['updatedAt', $now, $now],
        ];
    }

    public function testBeforeSave()
    {
        $obj = new Maillist();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
    }

    public function testBeforeUpdate()
    {
        $obj = new Maillist();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->preUpdate();

        $this->assertInstanceOf('\DateTime', $obj->getUpdatedAt());
        $this->assertNull($obj->getCreatedAt());
    }
}
