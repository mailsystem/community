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

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
    }

    public function getSetDataProvider()
    {
        $now = new \DateTime('now');

        return array(
            'subject' => array('subject', 'subject', 'subject'),
            'body' => array('body', 'body', 'body'),
            'createdAt' => array('createdAt', $now, $now),
            'updatedAt' => array('updatedAt', $now, $now),
        );
    }

    public function testBeforeSave()
    {
        $obj = new Letter();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
        $this->assertNull('\DateTime', $obj->getUpdatedAt());
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
