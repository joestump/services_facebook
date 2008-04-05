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
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Services_Facebook
 */

require_once 'Services/Facebook/Common.php';

/**
 * Facebook Users Interface
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Users extends Services_Facebook_Common
{
    /**
     * Default user fields
     *
     * @access      private
     * @var         array       $userFields     List of allowed getInfo fields
     */
    private $userFields = array(
        'about_me', 'activities', 'affiliations', 'birthday', 'books',
        'current_location', 'education_history', 'first_name', 'has_added_app',
        'hometown_location', 'hs_info', 'interests', 'is_app_user', 
        'last_name', 'meeting_for', 'meeting_sex', 'movies', 'music', 'name',
        'notes_count', 'pic', 'pic_small', 'pic_square', 'political',
        'profile_update_time', 'quotes', 'relationship_status', 'religion',
        'sex', 'significant_other_id', 'status', 'timezone', 'tv',
        'wall_count', 'work_history'
    );

    /**
     * Has the current user added this application?
     *
     * @access      public
     * @return      boolean
     */
    public function isAppAdded()
    {
        $result = $this->sendRequest('users.isAppAdded', array(
            'session_key' => $this->sessionKey
        )); 

        return (intval((string)$result) == 1);
    }

    /**
     * Set a user's status message
     *
     * Set $status to true to clear the status or a string to change the 
     * actual status message.
     *
     * @access      public
     * @param       mixed       $status     Set to true to clear status
     * @return      boolean     True on success, false on failure
     * @link        http://wiki.developers.facebook.com/index.php/Users.setStatus
     * @link        http://wiki.developers.facebook.com/index.php/Extended_permission
     */
    public function setStatus($status)
    {
        $args = array(
            'session_key' => $this->sessionKey,
        );

        if (is_bool($status) && $status === true) {
            $args['clear'] = 'true';
        } else {
            $args['status'] = $status;
        }

        $res = $this->sendRequest('users.setStatus', $args); 
        return (intval((string)$res) == 1);
    }

    /**
     * Get user info
     *
     * @param       mixed       $uids       A single uid or array of uids
     * @param       array       $fields     List of fields to retrieve
     * @return      object      SimpleXmlElement of result
     * @link        http://wiki.developers.facebook.com/index.php/Users.getInfo
     */
    public function getInfo($uids, array $fields = array())
    {
        if (is_array($uids)) {
            $uids = implode(',', $uids);
        } 

        if (!count($fields)) {
            $fields = $this->userFields;
        }

        return $this->sendRequest('users.getInfo', array(
            'session_key' => $this->sessionKey,
            'uids' => $uids,
            'fields' => implode(',', $fields)
        ));
    }

    /**
     * Get the currently logged in uid
     *
     * Returns the Facebook uid of the person currently "logged in" as 
     * specified by $sessionKey.
     *
     * @return      int         The uid of the person logged in
     * @see         Services_Digg::$sessionKey
     * @link        http://wiki.developers.facebook.com/index.php/Users.getLoggedInUser
     */
    public function getLoggedInUser()
    {
        $result = $this->sendRequest('users.getLoggedInUser', array(
            'session_key' => $this->sessionKey
        ));

        return intval((string)$result);
    }

    /**
     * Has given extended permission
     *
     * @access      public
     * @param       string      $perm           Either status_update or photo_upload
     * @return      boolean     True if user has enabled extended permission
     * @link        http://wiki.developers.facebook.com/index.php/Users.hasAppPermission
     */
    public function hasAppPermission($perm)
    {
        if (!in_array($perm, array('status_update', 'photo_upload'))) {
            throw new Services_Facebook_Exception('Invalid extended permission type supplied: ' . $perm);
        }

        $result = $this->sendRequest('users.hasAppPermission', array(
            'session_key' => $this->sessionKey,
            'ext_perm' => $perm
        ));

        return (intval((string)$result) == 1);
    }
}

?>
