<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Week;

class WeekFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Week('test', 'Test');

        $this->assertSame('week', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
