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
    public function it_is_an_instance_of_image_contract()
    {
        $image = new Image('test', 'Test');

        $this->assertInstanceOf(\Administr\Form\Contracts\Image::class, $image);
    }

    /** @test */
    public function it_returns_url_to_img()
    {
        $src = 'http://path-to-file.jpg';

        $image = new Image('test', 'Test');
        $image->setSrc($src);

        $this->assertSame($src, $image->getSrc());
    }

}
