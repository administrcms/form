<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Time;

class TimeFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Time('test', 'Test');

        $this->assertSame('time', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
