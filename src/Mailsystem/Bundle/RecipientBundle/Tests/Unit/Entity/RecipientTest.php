<?php
namespace Mailsystem\Bundle\RecipientBundle\Tests\Unit\Entity;

use Mailsystem\Bundle\RecipientBundle\Entity\Recipient;

class RecipientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetDataProvider
     */
    public function testGetSet($property, $value, $expected)
    {
        $obj = new Recipient();

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
            'firstName' => array('firstName', 'firstName', 'firstName'),
            'lastName' => array('lastName', 'lastName', 'lastName'),
            'email' => array('email', 'email@email.com', 'email@email.com'),
            'phone' => array('phone', '123456789', '123456789'),
            'skype' => array('skype', 'skype', 'skype'),
            'position' => array('position', 'position', 'position'),
            'company' => array('company', 'company', 'company'),
            'birthDate' => array('birthDate', $now, $now),
            'description' => array('description', 'description', 'description'),
            'createdAt' => array('createdAt', $now, $now),
            'updatedAt' => array('updatedAt', $now, $now),
        ];
    }

    public function testBeforeSave()
    {
        $obj = new Recipient();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
    }

    public function testBeforeUpdate()
    {
        $obj = new Recipient();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->preUpdate();

        $this->assertInstanceOf('\DateTime', $obj->getUpdatedAt());
        $this->assertNull($obj->getCreatedAt());
    }

    /**
     * test maillist functionality for recipient
     */
    public function testMaillist()
    {
        $maillist = $this->getMockBuilder('Mailsystem\Bundle\MaillistBundle\Entity\Maillist')
            ->disableOriginalConstructor()
            ->getMock();

        $obj = new Recipient();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $this->assertEmpty($obj->getMaillists());
        $obj->addMaillist($maillist);
        $this->assertNotEmpty($obj->getMaillists());
        $obj->removeMaillist($maillist);
        $this->assertEmpty($obj->getMaillists());
    }
}
