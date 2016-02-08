<?php

use Administr\Form\Field\Hidden;

class HiddenFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_full_html()
    {
        $field = new Hidden('test', 'Test');

        $this->assertSame('<input type="hidden" id="test" name="test" value="Test">', $field->render());
    }
}
