<?php

namespace Administr\Form\Field;

use PHPUnit_Framework_TestCase;

class EmailFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new Email('test', 'Test');

        $this->assertSame('<label for="test">Test</label>' . "\n" . '<input type="email" id="test" name="test" value="">', $field->render());
    }
}

function old($key)
{
    return '';
}