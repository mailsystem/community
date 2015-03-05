<?php
namespace Mailsystem\Bundle\LetterBundle\Tests\Unit\Entity;

use Mailsystem\Bundle\LetterBundle\Entity\LetterTemplate;

class LetterTemplateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetDataProvider
     */
    public function testGetSet($property, $value, $expected)
    {
        $obj = new LetterTemplate();

        call_user_func_array(array($obj, 'set' . ucfirst($property)), array($value));
        $this->assertEquals($expected, call_user_func_array(array($obj, 'get' . ucfirst($property)), array()));
    }

    public function getSetDataProvider()
    {
        $now = new \DateTime('now');

        return array(
            'name'      => array('name', 'name', 'name'),
            'body'      => array('body', 'body', 'body'),
            'createdAt' => array('createdAt', $now, $now),
            'updatedAt' => array('updatedAt', $now, $now),
        );
    }

    public function testBeforeSave()
    {
        $obj = new LetterTemplate();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->prePersist();

        $this->assertInstanceOf('\DateTime', $obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
    }

    public function te1stBeforeUpdate()
    {
        $obj = new LetterTemplate();
        $this->assertNull($obj->getCreatedAt());
        $this->assertNull($obj->getUpdatedAt());
        $obj->preUpdate();

        $this->assertInstanceOf('\DateTime', $obj->getUpdatedAt());
        $this->assertNull($obj->getCreatedAt());
    }
}
