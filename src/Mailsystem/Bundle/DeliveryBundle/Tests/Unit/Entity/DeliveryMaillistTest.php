<?php
namespace Mailsystem\Bundle\DeliveryBundle\Tests\Unit\Entity;

use Mailsystem\Bundle\DeliveryBundle\Entity\DeliveryMaillist;

class DeliveryMaillistTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetDataProvider
     */
    public function testGetSet($property, $value, $expected)
    {
        $obj = new DeliveryMaillist();

        call_user_func_array([$obj, 'set'.ucfirst($property)], array($value));
        $this->assertEquals($expected, call_user_func_array(array($obj, 'get'.ucfirst($property)), array()));
    }

    public function getSetDataProvider()
    {
        $owner = $this->getMockBuilder('Oro\Bundle\UserBundle\Entity\User')
            ->disableOriginalConstructor()
            ->getMock();
        $organization = $this->getMockBuilder('Oro\Bundle\OrganizationBundle\Entity\Organization')
            ->disableOriginalConstructor()
            ->getMock();
        $letterTemplate = $this->getMockBuilder('Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate')
            ->disableOriginalConstructor()
            ->getMock();
        $maillist = $this->getMockBuilder('Mailsystem\Bundle\MaillistBundle\Entity\Maillist')
            ->disableOriginalConstructor()
            ->getMock();

        $now = new \DateTime('now');

        return array(
            'owner' => array('owner', $owner, $owner),
            'organization' => array('organization', $organization, $organization),
            'letterTemplate' => array('letterTemplate', $letterTemplate, $letterTemplate),
            'maillist' => array('maillist', $maillist, $maillist),
            'notes' => array('notes', 'notes', 'notes'),
            'createdAt' => array('createdAt', $now, $now),
        );
    }

    public function testBeforeSave()
    {
        $obj = new DeliveryMaillist();
        $this->assertNull($obj->getCreatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
    }
}
