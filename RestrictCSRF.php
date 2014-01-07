<?php

/**
 * CSRF Protection Class
 *
 * @project: RestrictCSRF
 * @purpose: This is the RestrictCSRF Class
 * @version: 1.0
 *
 * @author: Saurabh Sinha
 * @created on: 1 Aug, 2013
 *
 * @url: www.saurabhsinha.in
 * @email: sinha.ksaurabh@gmail.com
 * @license: Saurabh Sinha
 *
 */

class RestrictCSRF
{
    
    /**
     * @purpose: This function generates a Random String
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $length - length of the string to be generated
     * @return type
     */
    protected static function generateRandonString($length = 30)
    {
        $chars = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $result = '';
        for ($p = 0; $p < $length; $p++)
        {
            $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
        }	   
        return $result;
    }

    /**
     * @purpose: This function generates the CSRF Token
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $keyValue - name of the control holding the token value
     * @return boolean
     */
    public static function generateToken($keyValue)
    {
        if(isset($keyValue) && $keyValue != '')
        {
            $basePage = self::getCurrentPage();
            $token = base64_encode(time() . self::generateRandonString());
            $_SESSION[$basePage]['token_' . $keyValue] = $token;
            return $token;
        }
        return false;
    }

    /**
     * @purpose: This function gets the Protocol being used to serve the request
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @return $protocol - the protocol used to serve the request
     */
    protected static function getProtocol()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol;
    }

    /**
     * @purpose: This function gets the complete url for the present page and then encodes it
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @return $presentPageLink - encoded value of the present page url
     */
    protected static function getCurrentPage()
    {
        $presentPageLink = self::getProtocol() . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
        return base64_encode($presentPageLink);
    }

    /**
     * @purpose: This function checks the token on action page with the Token generated earlier
     * @author: Saurabh Sinha
     * @created: 01/08/2013
     * @param type $keyValue - name of the control holding the token value
     * @param type $checkArray - accray in which the $keyValue exists
     * @return boolean
     */
    public static function checkToken($keyValue, $checkArray)
    {
        if(isset($keyValue) && $keyValue != '')
        {
            $refererPage = base64_encode($_SERVER['HTTP_REFERER']);
            if(isset($checkArray) && isset($checkArray[$keyValue]) && $checkArray[$keyValue] != '')
            {
                $token = $checkArray[$keyValue];
                if($_SESSION[$refererPage]['token_' . $keyValue] == $token)
                {
                        unset($_SESSION[$refererPage]);
                        return true;
                }
                return false;
            }
            return false;
        }
    }
}

?>
