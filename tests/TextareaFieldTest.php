<?php

namespace Administr\Form\Field;

use PHPUnit_Framework_TestCase;

class TextareaFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_full_html()
    {
        $field = new Textarea('test', 'Test');

        $this->assertSame('<label for="test">Test</label>' . "\n" . '<textarea id="test" name="test"></textarea>', $field->render());
    }
}