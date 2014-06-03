securityClass
=============

This is a set of class which can secure the application against XSS and SQL Injection.

This class will also help to fight against the Cross-Site Request Forgery (CSRF).

There are 2 different classes for both the functionalities which can be used in package as well as independent class.

Usage for FilterClass
----------------------------------------

1. For Filtering a Single value

	$objString = Nimbuzz_FilterClass::prepareDataObject($valueToFilter, $filterArray);
	$finalValue = Nimbuzz_FilterClass::filterDataValue($objString);

	In Above
	a. $valueToFilter: Teh value which can to be filtered
	b. $filterArray: operation to be performed on the string
					eg: $filterArray = array('strip_tags' => array(), 'addslashes' => array());


2. For Filtering the complte array
	$resultArray = Nimbuzz_FilterClass::filterXSS($arrayToFilter);

	In Above: 
	$arrayToFilter: This is the array to be filtered ($_POST, $_GET, $_REQUEST, or any array with values);

	Note: This is only to filter XSS
