<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

class AbstractFieldTypeTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_gives_basic_rendering_of_a_field()
    {
        $stub = $this->getMockForAbstractClass(AbstractType::class, ['test', 'Test']);
        $stub->expects($this->any())
            ->method('renderField')
            ->will($this->returnValue('1'));

        $this->assertSame('<label for="test">Test</label>'."\n".'1', $stub->render());
    }

    /** @test */
    public function it_returns_an_empty_string_for_no_args()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame('', $field->renderAttributes());
    }

    /** @test */
    public function it_returns_correct_string_for_args()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame(' test="miro"', $field->renderAttributes(['test' => 'miro']));
    }

    /** @test */
    public function it_renders_the_correct_label_html()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame('<label for="test">Test</label>'."\n", $field->renderLabel());
    }

    /** @test */
    public function it_renders_errors_when_given()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame("test\ntest2", $field->renderErrors(['test', 'test2']));
    }

    /** @test */
    public function it_gets_field_name()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame('test', $field->getName());
    }
    
    /** @test */
    public function it_sets_field_name()
    {
        $field = new Text('test', 'Test');
        $field->setName('named');

        $this->assertSame('named', $field->getName());
    }

    /** @test */
    public function it_gets_field_label()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame('Test', $field->getLabel());
    }

    /** @test */
    public function it_sets_field_label()
    {
        $field = new Text('test', 'Test');
        $field->setLabel('labeled');

        $this->assertSame('labeled', $field->getLabel());
    }

    /** @test */
    public function it_gets_field_options()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame([], $field->getOptions());
    }

    /** @test */
    public function it_returns_the_field_string_representation()
    {
        $field = new Text('test', 'Test');

        $this->assertSame('<label for="test">Test</label>'."\n".'<input type="text" id="test" name="test" value="">', $field->__toString());
    }

    /** @test */
    public function it_appends_an_option()
    {
        $field = new Text('test', 'Test');
        $field->appendOption('new', 'option');

        $this->assertSame(['new' => 'option'], $field->getOptions());
    }
    
    /** @test */
    public function it_sets_translatable_option()
    {
        $field = new Text('test', 'Test');
        $field->translated();

        $this->assertContains('translated', $field->getOptions());
    }
}
