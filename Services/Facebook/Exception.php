<?php

/**
 * Services_Facebook_Exception
 *
 * All calls to the API can result in a few different errors; an HTTP error,
 * an API error or some other random cURL error. In all cases the package will
 * throw a Services_Facebook_Exception.
 *
 * @category    Services
 * @package     Services_Facebook
 */
class Services_Facebook_Exception extends Exception
{
    /**
     * Last API call
     *
     * This is the URI of the API call that generated the error. The error
     * message and code from the error is passed as well.
     *
     * @var         string      $lastCall       URI of last API call
     */
    protected $lastCall = '';

    /**
     * Constructor
     *
     * @param       string      $message
     * @param       int         $code
     * @param       string      $lastCall       URI of last API call
     */
    public function __construct($message, $code = 0, $lastCall = '')
    {
        parent::__construct($message, $code);
        $this->lastCall = $lastCall;
    }

    /**
     * Returns last API call
     *
     * @return      string      
     * @see         Services_Facebook_Exception::$lastCall
     */
    public function getLastCall()
    {
        return $this->lastCall;
    }
}

?>
