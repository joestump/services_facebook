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
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net> 
 * @copyright   Joe Stump <joe@joestump.net>  
 * @license     http://www.opensource.org/licenses/bsd-license.php 
 * @version     CVS: $Id:$
 * @link        http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';

/**
 * Facebook Pages Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_Pages extends Services_Facebook_Common
{
	/**
	 * Checks whether the logged-in user is the admin for a given page. 
	 *
	 * @param		int		Page ID, optional
	 * @return 		boolean
	 * @link		http://wiki.developers.facebook.com/index.php/Pages.isAdmin
	 **/
	public function isAdmin($page_id = null)
	{
		$result = $this->sendRequest('pages.isAdmin', array(
									 'session_key' => $this->sessionKey,
									 'page_id' => $page_id
				  ));
		return (intval((string)$result) == 1);
	}
	
	/**
	 * Checks whether the page has added the application. 
	 *
	 * @param		int		Page ID, optional
	 * @return 		boolean
	 * @link		http://wiki.developers.facebook.com/index.php/Pages.isAppAdded
	 **/
	public function isAppAdded($page_id = null)
	{
		$result = $this->sendRequest('pages.isAppAdded', array(
									 'session_key' => $this->sessionKey,
									 'page_id' => $page_id
				  ));
		return (intval((string)$result) == 1);
	}
    
	/**
	 * Checks whether a user is a fan of a given Page. Doesn't work for Application about Pages.
	 *
	 * @param		int		Page ID, optional
	 * @param		int		User ID of the person to test, defaults to logged-in user
	 * @return 		boolean
	 * @link		http://wiki.developers.facebook.com/index.php/Pages.isFan
	 **/
	public function isFan($page_id = null, $uid = null)
	{
		$result = $this->sendRequest('pages.isFan', array(
									 'session_key' => $this->sessionKey,
									 'page_id' 	=> $page_id,
									 'uid'		=> $uid
				  ));
		return (intval((string)$result) == 1);
	}
}

?>
