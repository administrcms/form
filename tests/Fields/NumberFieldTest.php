<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Number;

class NumberFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Number('test', 'Test');

        $this->assertSame('number', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
