<?php

use Administr\Form\Field\Radio;

class RadioFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_renders_the_full_html()
    {
        $field = new Radio('test', 'Test');

        $this->assertSame('<label for="test">Test</label><input type="radio" id="test" name="test">', $field->render());
    }
}
