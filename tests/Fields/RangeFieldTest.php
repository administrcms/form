<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Range;

class RangeFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Range('test', 'Test');

        $this->assertSame('range', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
