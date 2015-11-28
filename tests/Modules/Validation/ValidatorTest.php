<?php

namespace Test\Modules\Validation;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $_validator = $this->getMockForAbstractClass('Validation\Validator');
        $_auraFilter = \PHPUnit_Framework_Assert::readAttribute($_validator, '_auraFilter');
        $this->assertInstanceOf('\Aura\Filter\ValueFilter', $_auraFilter);
    }

}
