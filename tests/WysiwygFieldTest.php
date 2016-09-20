<?php


use Administr\Form\Field\Textarea;
use Administr\Form\Field\Wysiwyg;

class WysiwygFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_an_instance_of_textarea()
    {
        $field = new Wysiwyg('test', 'Test');

        $this->assertSame('administr/form::textarea', $field->getView());
        $this->assertContains('administr-wysiwyg', $field->getOption('class'));
        $this->assertInstanceOf(Textarea::class, $field);
    }
}

class Asset {
    public static function wysiwyg()
    {
        return null;
    }
}