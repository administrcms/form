<?php

namespace Administr\Form\Field;

class PasswordFieldTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Password('test', 'Test');

        $this->assertSame('password', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }

    /** @test */
    public function it_always_has_a_null_value_on_init()
    {
        $field = new Password('test', 'Test', ['value' => true]);
        $field->setValue(true);

        $this->assertNull($field->getValue());
    }
}
