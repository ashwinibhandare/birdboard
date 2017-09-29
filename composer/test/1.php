<?php
namespace  phpreboot\tddworkshop;

class Calculator {
   

    public function add($numbers = '') {         ///// Function for addition    
    
        if (empty($numbers)) {
            return 0;
        }
      
        if (!is_string($numbers)) {
            throw new \InvalidArgumentException('Parameters must be a string');
        }
        
        $numbersArray = preg_split( '/[n;,\\\\ ]/',$numbers); //split array with special charasters
        
        foreach ($numbersArray as $key=>$value) {             
            if($numbersArray[$key] == null) {
                unset($numbersArray[$key]);
            }
        }
        
        $negativeNumberArray=array();                        // array of negative number
        foreach ($numbersArray as $key=>$value) {
            if($numbersArray[$key]<0) {
                 $negativeNumberArray[]=$numbersArray[$key];
            }
        }
        
        if(!empty($negativeNumberArray)) {                  //if array of negative number is not empty then throw exception
            $negativeNumbers=implode(" , ",$negativeNumberArray); 
            throw new \InvalidArgumentException("Negative numbers  ( $negativeNumbers ) not allowed.");
        }
      
        foreach ($numbersArray as $key=>$value) {           //array values greater than 1000 are ignored
            if($numbersArray[$key]>1000) {
                unset($numbersArray[$key]);
            }
        }
       
        if (array_filter($numbersArray, 'is_numeric') !== $numbersArray) {
            throw new \InvalidArgumentException('Parameters string must contain numbers');
        }

        return array_sum($numbersArray);
    }  

    
public function multiplication($numbers = '') {         ///// Function for Multiplication
    
        if (empty($numbers)) {
            return 0;
        }
        
        if (!is_string($numbers)) {
            throw new \InvalidArgumentException('Parameters must be a string');
        }
        
        $numbersArray = preg_split( '/[n;,\\\\ ]/',$numbers);  //split array with special charasters
        
        foreach ($numbersArray as $key=>$value) {
            if($numbersArray[$key] == null) {
                unset($numbersArray[$key]);
            }
        }
       
  
        
        $negativeNumberArray=array();                         // array of negative number
        foreach ($numbersArray as $key=>$value) {
            if($numbersArray[$key]<0) {
                 $negativeNumberArray[]=$numbersArray[$key];
            }
        }
        
        if(!empty($negativeNumberArray)) {                    //if array of negative number is not empty then throw exception
            $negativeNumbers=implode(" , ",$negativeNumberArray); 
            throw new \InvalidArgumentException("Negative numbers  ( $negativeNumbers ) not allowed.");
        }
        
        foreach ($numbersArray as $key=>$value) {              //array values greater than 1000 are ignored 
            if($numbersArray[$key]>1000) {
                unset($numbersArray[$key]);
            }
        }
        
        if (array_filter($numbersArray, 'is_numeric') !== $numbersArray) {
            throw new \InvalidArgumentException('Parameters string must contain numbers');
        }
        
        return array_product($numbersArray);
        
}
    
}    