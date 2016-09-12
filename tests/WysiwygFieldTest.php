<?php

use Administr\Form\Field\Textarea;
use Administr\Form\Field\Wysiwyg;

class WysiwygFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_an_instance_of_textarea()
    {
        $wysiwyg = new Wysiwyg('test', 'Test');

        $this->assertInstanceOf(Textarea::class, $wysiwyg);
    }

    /** @test */
    public function it_adds_class_for_tinymce_to_find()
    {
        $wysiwyg = new Wysiwyg('test', 'Test');

        $this->assertContains('administr-wysiwyg', $wysiwyg->getOption('class'));
    }
}
