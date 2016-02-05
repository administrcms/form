<?php

use Administr\Form\Field\Reset;

class ResetFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new Reset('test', 'Test');

        $this->assertSame('<input type="reset" id="test" name="test" value="Test">', $field->render());
    }
}
