<?php

use Administr\Form\Field\Text;

class TextFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_the_correct_field_html()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('<input type="text" id="test" name="test">', $field->renderField());
    }
}