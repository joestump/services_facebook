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
 * @author    Joe Stump <joe@joestump.net> 
 * @copyright 2007-2008 Joe Stump <joe@joestump.net>  
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   Release: @package_version@
 * @link      http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';
require_once 'Services/Facebook/Exception.php';

/**
 * Services_Facebook
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: @package_version@
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook
{
    /**
     * Facebok application API key 
     *
     * @var string $apiKey 32 character api_key from Facebook
     * @static
     */
    static public $apiKey = '';

    /**
     * Facebok application secret 
     *
     * The Facebook secret token is used to both sign requests sent to 
     * Facebook and to verify requests sent from Facebook to your application.
     *
     * @var string $secret 32 character secret from Facebook
     * @static
     */
    static public $secret = '';

    /**
     * Currently logged in user
     * 
     * @var string $sessionKey
     */
    public $sessionKey = '';

    /**
     * Instances of various drivers
     *
     * @var array $instances
     */
    static protected $instances = array();

    /**
     * Available drivers
     *
     * @var array $drivers
     */
    static protected $drivers = array(
        'admin'         => 'Admin',
        'application'   => 'Application',
        'auth'          => 'Auth',
        'data'          => 'Data',
        'events'        => 'Events',
        'fbml'          => 'FBML',
        'fql'           => 'FQL',
        'feed'          => 'Feed',
        'friends'       => 'Friends',
        'groups'        => 'Friends',
        'marketplace'   => 'MarketPlace',
        'notifications' => 'Notifications',
        'pages'         => 'Pages',
        'photos'        => 'Photos',
        'profile'       => 'Profile',
        'share'         => 'Share',
        'users'         => 'Users'
    );

    /**
     * Create a facebook service 
     *
     * @param string $endPoint Services to create
     * 
     * @return object Instance of Facebook endpoint
     * @throws Services_Facebook_Exception
     */
    static protected function factory($endPoint)
    {
        $file = 'Services/Facebook/' . $endPoint . '.php';
        include_once $file;
        $class = 'Services_Facebook_' . $endPoint;
        if (!class_exists($class)) {
            throw new Services_Facebook_Exception('Class not found ' . $class);
        } 

        $instance = new $class();
        return $instance;
    }

    /**
     * Lazy loader for Facebook drivers
     *
     * @param string $driver The Facebook driver/endpoint to load
     * 
     * @throws Services_Facebook_Exception
     * @return object
     */
    public function __get($driver)
    {
        $driver = strtolower($driver);
        if (!isset(self::$drivers[$driver])) {
            throw new Services_Facebook_Exception(
                'The driver requested, ' . $driver . ', is not supported'
            );
        } else {
            $driver = self::$drivers[$driver];
        }

        if (isset(self::$instances[$driver])) {
            return self::$instances[$driver];
        } 

        self::$instances[$driver] = self::factory($driver);
        self::$instances[$driver]->sessionKey = $this->sessionKey;
        return self::$instances[$driver];
    }

    /**
     * Validates requests from Facebook
     *
     * Facebook sends a series of $_POST variables when it requests a canvas
     * page or sends a user to the post removal URL. This function validates
     * that request came from Facebook. This function returns true if the 
     * request came from Facebook.
     * 
     * Both the signature of the request and the api_key is verified. If the
     * api_key given doesn't match up to the current Services_Facebook::$apiKey
     * then it will return false. 
     *
     * @param array $args Normally the $_POST array
     *
     * @return boolean True if the request signature is valid
     */
    static public function isValidRequest($args)
    {
        if ($args['fb_sig_api_key'] != Services_Facebook::$apiKey) {
            return false;
        }

        ksort($args);

        $sig = '';
        foreach ($args as $k => $v) {
            if ($k == 'fb_sig') {
                continue;
            }
        
            // The signature is based on fb_sig_* fields only. Extra POST
            // args are passed along, but don't alter the signature.
            if (preg_match('/^fb_sig_/', $k)) {
                $sig .= substr($k, 7) . '=' . $v;
            }
        }        

        return (md5($sig . Services_Facebook::$secret) == $args['fb_sig']); 
    }
}

?>
