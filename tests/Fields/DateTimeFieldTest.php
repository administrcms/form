<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\DateTime;

class DateTimeFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new DateTime('test', 'Test');

        $this->assertSame('datetime-local', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
