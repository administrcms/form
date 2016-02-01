<?php

use Administr\Form\Field\Email;

class EmailFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_the_correct_field_html()
    {
        $field = new Email('test', 'Test');

        $this->assertSame('<input type="email" id="test" name="test">', $field->renderField());
    }
}
