<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Date;

class DateFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Date('test', 'Test');

        $this->assertSame('date', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
