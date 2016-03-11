<?php

use Administr\Form\Field\File;

class FileFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_correct_field_html()
    {
        $field = new File('test', 'Test');

        $this->assertSame('<label for="test">Test</label>'."\n".'<input type="file" id="test" name="test">', $field->render());
    }
}
