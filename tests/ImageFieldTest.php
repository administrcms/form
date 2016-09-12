<?php

use Administr\Form\Field\File;
use Administr\Form\Field\Image;

class ImageFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_is_an_instance_of_file()
    {
        $image = new Image('test', 'Test');

        $this->assertInstanceOf(File::class, $image);
    }

    /** @test */
    public function it_renders_an_img_with_administr_class_name()
    {
        $imgSrc = 'http://path-to-file.jpg';

        $image = new Image('test', 'Test');
        $image->setSrc($imgSrc);

        $img = $image->render();

        $this->assertContains($imgSrc, $img);
        $this->assertContains('administr_image_type', $img);
    }

}
