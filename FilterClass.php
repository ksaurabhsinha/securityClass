<?php

/**
 * Filter XSS and SQL Injection
 *
 * @project: FilterClass
 * @purpose: This class manages the data filteration for XSS and SQL Injection
 * @version: 1.0
 *
 * @author: Saurabh Sinha
 * @created on: 30 Jul, 2013
 *
 * @url: http://www.saurabhsinha.in
 * @email: sinha.ksaurabh@gmail.com
 * @license: Saurabh Sinha
 *
 */
class FilterClass {
    
    /**
     * @purpose: This function filters the Data with the Spcified array of Filter Function and Arguments.
     * @author: Saurabh Sinha
     * @created: 30/07/2013
     * @param type $obj - object with string and filters
     * @return boolean
     */
    static function filterDataValue($obj)
    {
        if(is_object($obj))
        {
            if(isset($obj->string) && $obj->string != '')
            {
                $stringValue = $obj->string;
                if(isset($obj->filters) && is_array($obj->filters))
                {
                    foreach($obj->filters as $filterFunction=>$filterArgs)
                    {
                        if(is_callable($filterFunction))
                        {
                            //put the string to be filtered at the top of the array
                            array_unshift($filterArgs, $stringValue);
                            $stringValue = call_user_func_array($filterFunction, $filterArgs);
                        }
                    }
                }
                return $stringValue;
            }
            return false;
        }
        return false;
    }

    /**
     * @purpose: This function returns an object with the String and array of Filter Functions with arguments which are to be used for filteration
     * @author: Saurabh Sinha
     * @created: 30/07/2013
     * @param type $string - string to be filtered
     * @param type $filterArray - array of filter functions to be used
     * @return \stdClass|boolean
     */
    static function prepareDataObject($string, $filterArray = array())
    {
        if(isset($string) && $string != '')
        {
                $objNew = new stdClass();
                $objNew->string = $string;
                $objNew->filters = array('strip_tags' => array(), 'addslashes' => array(), 'htmlspecialchars' => array(ENT_QUOTES));
                if(count($filterArray) > 0)
                {
                        $objNew->filters = $filterArray;
                }
                return $objNew;
        }
        return false;
    }
    
    /**
     * @purpose: This function filter the XSS for GET, POST and REQUEST
     * @author: Saurabh Sinha
     * @created: 30/07/2013
     * @param type $filterVarArray
     * @param type $skipArray
     * @return Array|boolean
     */
    static function filterXSS($filterVarArray, $skipArray = array())
    {
        if(is_array($filterVarArray) && count($filterVarArray) > 0)
        {
            foreach($filterVarArray as $gKey=>$gValue)
            {
                if(!in_array($gKey, $skipArray))
                {
                    if($gValue != '' && !is_array($gValue) && !is_object($gValue)){
                        $objString = self::prepareDataObject($gValue, array('htmlspecialchars' => array(ENT_QUOTES)));
                        $filterVarArray[$gKey] = self::filterDataValue($objString);
                    }
                }
            }
            return $filterVarArray;
        }
        return false;
    }
}

?>
