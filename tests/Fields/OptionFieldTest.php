<?php

namespace Administr\Form\Field;

class OptionFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Option('test', 'Test');
        $field->render();

        $this->assertSame('test', $field->getValue());
        $this->assertSame('administr/form::option', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
