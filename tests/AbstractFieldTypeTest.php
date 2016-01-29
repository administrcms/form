<?php

use Administr\Form\Field\AbstractType;
use Administr\Form\Field\Text;

class AbstractFieldTypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_gives_basic_rendering_of_a_field()
    {
        $stub = $this->getMockForAbstractClass(AbstractType::class, ['test', 'Test']);
        $stub->expects($this->any())
            ->method('renderField')
            ->will($this->returnValue('1'));

        $stub->expects($this->any())
            ->method('renderLabel')
            ->will($this->returnValue('2'));

        $stub->expects($this->any())
            ->method('renderErrors')
            ->will($this->returnValue('3'));

        $this->assertSame('213', $stub->render());
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_for_no_args()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame('', $field->renderAttributes());
    }

    /**
     * @test
     */
    public function it_returns_correct_string_for_args()
    {
        $field = new Text('test', 'Test');

        $this->assertInstanceOf(AbstractType::class, $field);
        $this->assertSame(' test="miro"', $field->renderAttributes(['test' => 'miro']));
    }
}