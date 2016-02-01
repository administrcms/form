<?php

use Administr\Form\Field\Email;

class EmailFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new Email('test', 'Test');

        $this->assertSame('<label for="test">Test</label><input type="email" id="test" name="test">', $field->render());
    }
}
