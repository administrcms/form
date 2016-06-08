<?php

class RadioGroupFieldTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_makes_radio_instances()
    {
        $radioGroup = new \Administr\Form\Field\RadioGroup('test', 'Test', function(\Administr\Form\Field\RadioGroup $group){
            $group->radio('yes', ['value' => 1]);
        });
        
        $this->assertCount(1, $radioGroup->getRadios());
        $this->assertSame('test', $radioGroup->getRadios()[0]->getName());
        $this->assertInstanceOf(\Administr\Form\Field\Radio::class, $radioGroup->getRadios()[0]);
    }
    
    /** @test */
    public function it_renders_correct_html()
    {
        $radioGroup = new \Administr\Form\Field\RadioGroup('test', 'Test', function(\Administr\Form\Field\RadioGroup $group){
            $group->radio('yes', ['value' => 1]);
        });

        $this->assertSame('<label class="radio-inline"><input type="radio" id="test" name="test" value="1">yes</label>', $radioGroup->renderField());
    }
    
    /** @test */
    public function it_renders_correct_label()
    {
        $radioGroup = new \Administr\Form\Field\RadioGroup('test', 'Test', function(\Administr\Form\Field\RadioGroup $group){
            $group->radio('yes', ['value' => 1]);
        });

        $this->assertSame('<label for="test" class="control-label">Test</label><br>', $radioGroup->renderLabel());
    }
}
