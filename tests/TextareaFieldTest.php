<?php

use Administr\Form\Field\Textarea;

class TextareaFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_the_correct_field_html()
    {
        $field = new Textarea('test', 'Test');

        $this->assertSame('<textarea id="test" name="test"></textarea>', $field->renderField());
    }
}
