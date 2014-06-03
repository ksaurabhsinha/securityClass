securityClass
=============

This is a set of class which can secure the application against XSS and SQL Injection.

This class will also help to fight against the Cross-Site Request Forgery (CSRF).

There are 2 different classes for both the functionalities which can be used in package as well as independent class.

Usage for FilterClass
----------------------------------------

1. For Filtering a Single value

	$objString = FilterClass::prepareDataObject($valueToFilter, $filterArray);
	$finalValue = FilterClass::filterDataValue($objString);

	In Above
	a. $valueToFilter: Teh value which can to be filtered
	b. $filterArray: operation to be performed on the string
					eg: $filterArray = array('strip_tags' => array(), 'addslashes' => array());


2. For Filtering the complte array
	$resultArray = FilterClass::filterXSS($arrayToFilter);

	In Above: 
	$arrayToFilter: This is the array to be filtered ($_POST, $_GET, $_REQUEST, or any array with values);

	Note: This is only to filter XSS
	

Usage for RestrictCSRF Class
----------------------------------------

1. Simple add

	<input type='hidden' value="<?=RestrictCSRF::generateToken('add_bot_form')?>" name='add_bot_form' id='add_bot_form'>

	in the form for which you want the CSRF Protection to be implemented

2. And on POST on the action page check

	if(!RestrictCSRF::checkToken(form_name_value, $array_to_be_checked))
    {
        redirect('index.php');
    }

	In above:

	a. form_name_value: name of the form on the design page
	b. $array_to_be_checked: the array which contains the CSRF token ($_POST, $_GET, $_REQUEST) as per the implementation.

