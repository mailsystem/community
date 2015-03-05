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

        return array(
            'name' => array('name', 'name', 'name'),
            'description' => array('description', 'description', 'description'),
            'createdAt' => array('createdAt', $now, $now),
            'updatedAt' => array('updatedAt', $now, $now),
        );
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
