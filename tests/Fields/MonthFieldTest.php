<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Month;

class MonthFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Month('test', 'Test');

        $this->assertSame('month', $field->getOption('type'));
        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
