<?php
namespace  phpreboot\tddworkshop;
    
use phpreboot\tddworkshop\Calculator;
    
class CalculatorTest extends \PHPUnit_Framework_TestCase 
{
    public function setUp() 
    {
        $this->calculator = new Calculator();
    }

    public function tearDown() 
    {
        $this->calculator = null;
    }
    
   
    public function testAddReturnsAnInteger() 
    {
        $result = $this->calculator->add();

        $this->assertInternalType('integer', $result, 'Result of `add` is not an integer.');
    }
    
    
    /**
     * @dataProvider additionProvider
     */
    public function testAddReturnSumForIntegerInput($input, $expected)
    {
        $sum = $this->calculator->add($input);
        $this->assertEquals($expected, $sum);
    }

    public function additionProvider()
    {
        return [
            ['', 0],
            ['2', 2],
            ['2,3', 5],
            ['2,4,6,8,10,20,30', 80],
            ['2,3,\n5', 10],
            ['\\\\;\\\\3;4', 7], 
            ['2,4,6,8,2000', 20]
        ];
    }
    
    /**
     * 
     * @expectedException InvalidArgumentException
     */
    public function testAddWithNonNumbersThrowException()
    {
        $this->calculator->add('1,a', 'Invalid parameter do not throw exception');
    }
    
      /**
     * 
     * @expectedException InvalidArgumentException
     */
    public function  testAddWithNegativeParameterThrowsException()
    {
        $this->calculator->add('3,-8', 'Negative parameter 3,-8 do not throw error');
    }
    
////////////////////////////-----FOR MULTIPLICATION--------//////////////
    public function testMultiplyReturnsAnInteger()
    {
        $result = $this->calculator->multiplication();

        $this->assertInternalType('integer', $result, 'Result of `Multiplication` is not an integer.');
    }
     /**
     * @dataProvider multiplicationProvider
     */
    public function testAddReturnMultiplicationForIntegerInput($input, $expected)
    {
        $multiplication = $this->calculator->multiplication($input);
        $this->assertEquals($expected, $multiplication);
    }

    public function multiplicationProvider()
    {
        return [
            ['', 1],
            ['2', 2],
            ['2,3', 6],
            ['2,4,2', 16],
            ['2,3,\n5', 30],
            ['\\\\;\\\\3;4', 12], 
            ['2,4,2000', 8]
        ];
    }
   /**
     * 
     * @expectedException InvalidArgumentException
     */
    public function testMultiplyWithNonNumbersThrowException()
    {
        $this->calculator->multiplication('1,a', 'Invalid parameter do not throw exception');
    }
    
     /**
     * 
     * @expectedException InvalidArgumentException
     */
    public function  testMultiplyWithNegativeParameterThrowsException()
    {
        $this->calculator->multiplication('3,-8', 'Negative parameter 3,-8 do not throw error');
    }
    
   
}
