<?php
namespace Test\Model\Form;

use Form\FormGenerator;

class FormGeneratorTest extends \PHPUnit_Framework_TestCase
{

    public function setUp()
    {
        FormGenerator::start('');
    }

    public function testStart()
    {
        FormGenerator::start('text');
        $this->assertEquals('<input type="text" >', FormGenerator::render());
    }

    public function testAddName()
    {
        FormGenerator::addName('AnyInputName');
        $this->assertEquals('< name="AnyInputName" >', FormGenerator::render());
    }

    public function testAddItem()
    {
        $itemsArray = [
            'id' => 'AnyId',
            'class' => 'AnyClass',
            'AnyOtherElement' => 'AnyValue'
        ];
        FormGenerator::addItem($itemsArray);
        $this->assertEquals(
            '< id="AnyId" class="AnyClass" AnyOtherElement="AnyValue">',
            FormGenerator::render()
        );
    }

    public function testRequired()
    {
        FormGenerator::required();
        $this->assertEquals('< required >', FormGenerator::render());
    }

    public function testGenerateInput()
    {
        FormGenerator::start('text');
        FormGenerator::addName('AnyInputName');
        $itemsArray = ['AnyElement' => 'AnyValue'];
        FormGenerator::addItem($itemsArray);
        FormGenerator::required();
        $this->assertEquals(
            '<input type="text" name="AnyInputName" required AnyElement="AnyValue">',
            FormGenerator::render()
        );
    }
}
