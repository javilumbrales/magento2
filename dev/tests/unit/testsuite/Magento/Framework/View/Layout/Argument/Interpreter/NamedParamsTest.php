<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Framework\View\Layout\Argument\Interpreter;

class NamedParamsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\Data\Argument\InterpreterInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $_interpreter;

    /**
     * @var NamedParams
     */
    protected $_model;

    protected function setUp()
    {
        $this->_interpreter = $this->getMockForAbstractClass('Magento\Framework\Data\Argument\InterpreterInterface');
        $this->_model = new NamedParams($this->_interpreter);
    }

    public function testEvaluate()
    {
        $input = [
            'param' => ['param1' => ['value' => 'value 1'], 'param2' => ['value' => 'value 2']],
        ];

        $this->_interpreter->expects(
            $this->at(0)
        )->method(
            'evaluate'
        )->with(
            ['value' => 'value 1']
        )->will(
            $this->returnValue('value 1 (evaluated)')
        );
        $this->_interpreter->expects(
            $this->at(1)
        )->method(
            'evaluate'
        )->with(
            ['value' => 'value 2']
        )->will(
            $this->returnValue('value 2 (evaluated)')
        );
        $expected = ['param1' => 'value 1 (evaluated)', 'param2' => 'value 2 (evaluated)'];

        $actual = $this->_model->evaluate($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider evaluateWrongParamDataProvider
     */
    public function testEvaluateWrongParam($input, $expectedExceptionMessage)
    {
        $this->setExpectedException('\InvalidArgumentException', $expectedExceptionMessage);
        $this->_model->evaluate($input);
    }

    public function evaluateWrongParamDataProvider()
    {
        return [
            'root param is non-array' => [
                ['param' => 'non-array'],
                'Layout argument parameters are expected to be an array',
            ],
            'individual param is non-array' => [
                ['param' => ['sub-param' => 'non-array']],
                'Parameter data of layout argument is expected to be an array',
            ]
        ];
    }
}
