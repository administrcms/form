<?php

use Administr\Form\Field\Submit;

class SubmitFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new Submit('test', 'Test');

        $this->assertSame('<input type="submit" id="test" name="test" value="Test">', $field->render());
    }
}
