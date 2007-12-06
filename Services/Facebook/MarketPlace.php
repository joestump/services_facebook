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

/**
 * Facebook Marketplace Interface
 *
 * @category    Services
 * @package     Services_Facebook
 * @author      Joe Stump <joe@joestump.net>
 * @link        http://wiki.developers.facebook.com
 */
class Services_Facebook_MarketPlace extends Services_Facebook_Common
{
    /**
     * Create (or Update) a marketplace listing
     *
     * @access      public
     * @param       object      $l          Instance of listing object
     * @return      object      Instance of listing object (with ID)
     * @throws      Services_Facebook_Exception
     */
    public function createListing(Services_Facebook_MarketPlace_Listing $l)
    {
        $l->validate();
        $result = $this->sendRequest('marketplace.createListing', array(
            'session_key' => $this->sessionKey,
            'listing_id' => $l->id,
            'show_on_profile' => (($l->showInProfile) ? '1' : '0'),
            'listing_attrs' => json_encode($l->data)
        ));

        $id = intval((string)$result);
        $l->id = $id;
        return $l;
    }

    /**
     * Get marketplace categories
     *
     * @access      public
     * @return      object
     * @throws      Services_Facebook_Exception
     */
    public function getCategories()
    {
        return $this->sendRequest('marketplace.getCategories', array(
            'session_key' => $this->sessionKey
        ));
    }

    /**
     * Get marketplace subcategories
     *
     * @access      public
     * @return      object
     * @throws      Services_Facebook_Exception
     */
    public function getSubCategories()
    {
        return $this->sendRequest('marketplace.getSubCategories', array(
            'session_key' => $this->sessionKey
        ));
    }

    public function getListings()
    {
    }


    public function removeListing()
    {
    }

    /**
     * Search marketplace listings
     *
     * @access      public
     * @param       string      $query
     * @param       string      $category
     * @param       string      $subCategory
     * @return      object
     * @throws      Services_Facebook_Exception
     */
    public function search($query, $category = '', $subCategory = '')
    {
        if (strlen($subCategory) && !strlen($category)) {
            throw new Services_Facebook_Exception('You must specify a category when searching by subCategory');
        }

        $args = array('session_key' => $this->sessionKey);
        if (strlen($category)) {
            $args['category'] = $category;
        }

        if (strlen($subCategory)) {
            $args['subcategory'] = $subCategory;
        }

        return $this->sendRequest('marketplace.search', $args);
    }
}

?>
