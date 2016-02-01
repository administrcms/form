<?php

use Administr\Form\Field\Select;

class SelectFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_renders_the_full_html()
    {
        $field = new Select('test', 'Test');

        $this->assertSame('<label for="test">Test</label>' . "\n" . '<select id="test" name="test"></select>', $field->render());
    }

    /** @test */
    public function it_renders_with_options_the_full_html()
    {
        $field = new Select('test', 'Test', [
            'value' => ['miro' => 'test']
        ]);

        $this->assertSame('<label for="test">Test</label>' . "\n" . '<select id="test" name="test"><option value="miro">test</option></select>', $field->render());
    }
}
