w<?php

use Administr\Form\Field\RadioGroup;

class RadioGroupFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_makes_radio_instances()
    {
        $group = new RadioGroup('test', 'Test', function (RadioGroup $group) {
            $group->radio('yes', ['value' => 1]);
        });

        $radios = $group->radios();

        $this->assertCount(1, $radios);
        $this->assertSame('test', $radios[0]->getName());
        $this->assertInstanceOf(\Administr\Form\Field\Radio::class, $radios[0]);
    }

    /** @test */
    public function it_renders_correct_html()
    {
        $group = (new RadioGroup('test', 'Test', function (RadioGroup $group) {
            $group->radio('yes', ['value' => 1]);
        }))->setValue(0);

        $radios = $group->radios();

        $this->assertInstanceOf(\Administr\Form\Field\Field::class, $group);
        $this->assertNull($radios[0]->getOption('checked'));
    }
}
