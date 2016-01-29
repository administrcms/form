<?php

use Administr\Form\Field\Checkbox;

class CheckboxFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_the_full_html()
    {
        $field = new Checkbox('test', 'Test');

        $this->assertSame('<label for="test">Test</label><input type="checkbox" id="test" name="test">', $field->render());
    }
}
