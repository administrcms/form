<?php

use Administr\Form\Field\Password;

class PasswordFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new Password('test', 'Test');

        $this->assertSame('<label for="test">Test</label>' . "\n" . '<input type="password" id="test" name="test" value="">', $field->render());
    }
}