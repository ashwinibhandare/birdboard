<?php
namespace  phpreboot\tddworkshop;

class Calculator 
{
 /**
  * Returns $numbersArray
  * 
  * @param string  $numbers
  * @return  array
  * @throws \InvalidArgumentException
  */  
    public function returnNumberArray(string $numbers):array 
    {
        if (empty($numbers)) {
            return [];
        }
      
        if (!is_string($numbers)) {
            throw new \InvalidArgumentException('Parameters must be a string');
        }
        $numbersArray= preg_split( '/[n;,\\\\ ]/',$numbers);   
        $negativeNumberArray=array();
        foreach ($numbersArray as $key=>$value) { 
        
        switch ($numbersArray[$key]) {
            case (null):
                unset($numbersArray[$key]);
                break;
            case ($numbersArray[$key]>1000):
                unset($numbersArray[$key]);
                break;
            case ($numbersArray[$key]<0):
                $negativeNumberArray[]=$numbersArray[$key];
                break;
        }
        }
        
        if(!empty($negativeNumberArray)) {                  
            $negativeNumbers=implode(" , ",$negativeNumberArray); 
            throw new \InvalidArgumentException("Negative numbers  ( $negativeNumbers ) not allowed.");
        }
      
        if (array_filter($numbersArray, 'is_numeric') !== $numbersArray) {
            throw new \InvalidArgumentException('Parameters string must contain numbers');
        }
        
        return $numbersArray;
    }
    
    /**
     * Return sum of array
     * 
     * @param string $numbers Numbers as a string
     * @return int Sum of numbers in input string.
     * @throws \InvalidArgumentException
     */
    public function add(string $numbers=''): int
    {   
        return array_sum($this->returnNumberArray($numbers));
    }  
    
    /**
     * Return multiplication of array
     * 
     * @param string $numbers Numbers as string
     * @return int product of numbers in input string
     * @throws \InvalidArgumentException
     */
    public function multiplication(string $numbers=''):int 
    {
        return array_product($this->returnNumberArray($numbers));
    }
}    