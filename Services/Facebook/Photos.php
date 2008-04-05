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

/**
 * Facebook Notifications Interface
 *
 * @category Services
 * @package  Services_Facebook
 * @author   Joe Stump <joe@joestump.net>
 * @license  http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link     http://wiki.developers.facebook.com
 */
class Services_Facebook_Photos extends Services_Facebook_Common
{
    /**
     * Image types allowed for upload
     *
     * Facebook doesn't specify which types of images you can upload so we
     * restrict file uploads to the "Big Three".
     *
     * @var         array       $imageTypes
     * @see         Services_Facebook_Photos::upload()
     */
    private $imageTypes = array(
        IMAGETYPE_GIF => 'image/gif',
        IMAGETYPE_JPEG => 'image/jpeg',
        IMAGETYPE_PNG => 'image/png'
    );

    /**
     * Add a tag to a photo
     *
     * Adds a tag to a photo. The x/y coordinates are a float based percentage
     * from the left/top of the photo. The tag parameter is either a valid 
     * Facebook uid or a simple text string for a tag.
     *
     * @access      public
     * @param       int         $pid        Picture ID to add tag to
     * @param       float       $x          Horizontal postion as percentage
     * @param       float       $y          Vertical position as percentage
     * @param       mixed       $tag        Integer = uid, String = textual tag
     * @return      boolean     True on success, false on failure
     * @link        http://wiki.developers.facebook.com/index.php/Photos.addTag
     */
    public function addTag($pid, $x, $y, $tag)
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'pid' => $pid,
            'x' => $x,
            'y' => $y
        );

        if (is_numeric($tag)) {
            $args['tag_uid'] = $tag;
        } else {
            $args['tag_text'] = $tag;
        }

        $res = $this->sendRequest('photos.addTag', $args);
        return (intval((string)$result) == 1);
    }

    /**
     * Add a series of tags to a photo
     *
     * @access      public
     * @param       int         $pid            Photo ID to attach tags to
     * @param       array       $tags           Array of tags to add to phot
     * @return      boolean     True if success, false on failure
     */
    public function addTags($pid, array $tags)
    {
        $res = $this->sendRequest('photos.addTag', array(
            'session_key' => $this->sessionKey,
            'tags' => json_encode($tags)
        ));

        return (intval((string)$result) == 1);
    }

    /**
     * Create a photo album
     *
     * @access      public
     * @param       string      $name           Name of photo album
     * @param       string      $location       Location of album
     * @param       string      $description    A short description of album
     * @link        http://wiki.developers.facebook.com/index.php/Photos.createAlbums
     */
    public function createAlbum($name, $location = '', $description = '')
    {
        $args = array(
            'session_key' => $this->sessionKey,
            'name' => $name
        );

        if (strlen($location)) {
            $args['location'] = $location;
        }

        if (strlen($description)) {
            $args['description'] = $description;
        }

        return $this->sendRequest('photos.createAlbum', $args);
    }

    /**
     * Get photos
     *
     * @access      public
     * @param       mixed       $pids       A single pid or an array of pids
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.get
     */
    public function getPhotos($pids)
    {
        if (is_array($pids)) {
            $pids = implode(',', $pids);
        }

        return $this->sendRequest('photos.get', array(
            'session_key' => $this->sessionKey,
            'pids' => $pids
        ));
    }

    /**
     * Get photos from a given album
     *  
     * @access      public
     * @param       int         $aid            Album ID to fetch photos from
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.get
     */
    public function getPhotosByAlbum($aid)
    {
        return $this->sendRequest('photos.get', array(
            'session_key' => $this->sessionKey,
            'aid' => $aid
        ));
    }

    /**
     * Get photos tagged with a specific user
     *
     * @access      public
     * @param       int         $uid            User ID to fetch photos for
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.get
     */
    public function getPhotosByUser($uid)
    {
        return $this->sendRequest('photos.get', array(
            'session_key' => $this->sessionKey,
            'subj_id' => $uid
        ));
    }

    /**
     * Get albums from photo ids
     *
     * @param       array       $pids       Array of Facebook pids
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.getAlbums
     */
    public function getAlbumsByPhotos(array $pids)
    {
        return $this->sendRequest('photos.getAlbums', array(
            'session_key' => $this->sessionKey,
            'pids' => implode(',', $pids)
        ));
    }

    /**
     * Get uid's photo albums
     *
     * @param       int         $uid        Facebok uid to fetch albums
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.getAlbums
     */
    public function getAlbumsByUser($uid)
    {
        return $this->sendRequest('photos.getAlbums', array(
            'session_key' => $this->sessionKey,
            'uid' => $uid
        ));
    }

    /**
     * Get tags for given pids
     *
     * @param       array       $pids       Facebook pids to fetch tags for
     * @return      object      Instance of SimpleXmlElement
     * @link        http://wiki.developers.facebook.com/index.php/Photos.getTags
     */
    public function getTags(array $pids)
    {
        return $this->sendRequest('photos.getTags', array(
            'session_key' => $this->sessionKey,
            'pids' => implode(',', $pids)
        ));
    }

    /**
     * Upload a photo
     *
     * @param       int         $aid        Album to upload photo into
     * @param       string      $caption    A short caption
     * @link        http://us3.php.net/manual/en/ref.curl.php#54150
     * @link        http://wiki.developers.facebook.com/index.php/Photos.upload 
     */
    public function upload($file, $aid = 0, $caption = '')
    {
        $type = exif_imagetype($file);
        if (!isset($this->imageTypes[$type])) {
            throw new Services_Facebook_Exception('You cannot upload this type of image', 0, $this->api);
        }

        $args = array(
            'method' => 'photos.upload',
            'v' => $this->version,
            'api_key' => Services_Facebook::$apiKey,
            'session_key' => $this->sessionKey,
            'call_id' => microtime(true),
            'format' => 'XML'
        ); 

        if ($aid > 0) {
            $args['aid'] = $aid;
        }

        if (strlen($caption)) {
            $args['caption'] = $caption;
        }

        $args = $this->signRequest($args);
        $args[basename($file)] = '@' . realpath($file);

        $ch = curl_init();
        $url = $this->api . '?method=photos.upload';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Services_Facebook_Exception(curl_error($ch), curl_errno($ch), $url);
        }

        $xml = simplexml_load_string($data);
        if (!$xml instanceof SimpleXmlElement) {
            throw new Services_Facebook_Exception('Could not parse XML response', 0, $url);
        }

        return $xml;
    }
}

?>
