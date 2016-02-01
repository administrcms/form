<?php

use Administr\Form\Field\Option;

class OptionFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_full_html()
    {
        $field = new Option('test', 'Test');

        $this->assertSame('<option value="test">Test</option>', $field->render());
    }
}
