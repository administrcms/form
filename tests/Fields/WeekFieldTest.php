<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Week;

class WeekFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Week('test', 'Test');

        $this->assertSame('administr/form::text', $field->getView());
        $this->assertInstanceOf(AbstractType::class, $field);
    }
}
