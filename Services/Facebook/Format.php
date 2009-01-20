<?php
/**
 * PHP5 interface for Facebook's REST API
 *
 * PHP version 5.1.0+
 *
 * LICENSE: This source file is subject to the New BSD license that is 
 * available through the world-wide-web at the following URI:
 * http://www.opensource.org/licenses/bsd-license.php. If you did not receive  
 * a copy of the New BSD License and are unable to obtain it through the web, 
 * please send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Services
 * @package   Services_Facebook
 * @author    Jeff Hodsdon <jeffhodsdon@gmail.com> 
 * @copyright 2007-2008 Joe Stump <joe@joestump.net>  
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

/**
 * Facebook Formating util class
 *
 * Facebook api calls maybe formated however it needs to be.  Therefore
 * there are classes that derive from Services_Facebook_Format_Interface
 * that will format a response correctly.
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Jeff Hodsdon <jeffhodsdon@gmail.com>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Format
{

    /**
     * Factory 
     * 
     * @param mixed $driver Which format to get
     *
     * @return Services_Facebook_Format_Interface Instance of the format
     */
    static public function factory($driver)
    {
        $driver = explode('_', $driver);
        $class  = 'Services_Facebook_Format_' . ucfirst($driver[0]);
        if (isset($driver[1])) {
            $class .= '_' . ucfirst($driver[1]);
        }

        $file = str_replace('_', '/', $class) . '.php';

        include_once $file;

        $instance = new $class;

        return $instance;
    }

    /**
     * Is formatted 
     * 
     * Determines whiether or not an endpoint as a custom
     * format.
     *
     * @param mixed $endpoint API endpoint. e.g. Users
     * @param mixed $method   API method. e.g. getInfo
     *
     * @return bool Formatted or not
     */
    static public function isFormatted($endpoint, $method)
    {
        $paths = explode(':', get_include_path());
        foreach ($paths as $path) {
            $file = 'Services/Facebook/Format/' . $endpoint .
                '/' . ucfirst($method) . '.php';
            if (file_exists($file)) {
                return true;
            }
        }

        return false;
    }

}

?>
