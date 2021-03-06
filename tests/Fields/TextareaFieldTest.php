<?php

use Administr\Form\Field\Field;
use Administr\Form\Field\Textarea;

class TextareaFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_a_correct_object()
    {
        $field = new Textarea('test', 'Test', ['value' => '']);

        $this->assertSame('administr/form::textarea', $field->getView());
        $this->assertInstanceOf(Field::class, $field);
    }
}
