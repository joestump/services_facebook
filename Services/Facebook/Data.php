<?php

require_once 'Services/Facebook/Common.php';
require_once 'Services/Facebook/Exception.php';

class Services_Facebook_Data extends Services_Facebook_Common
{
    const _PROP_TYPE_INTEGER = 1;
    const _PROP_TYPE_STRING = 2;
    const _PROP_TYPE_BLOB = 3;

    public function & getUserPreference($prefID) 
    {
        $args = array(
            'pref_id' => (int) $prefID,
        );

        return $this->callMethod('data.getUserPreference', $args);
    }

    public function & getUserPreferences()
    {
        return $this->callMethod('data.getUserPreferences');
    }

    public function & setUserPreference($prefID, $value)
    {
        $args = array(
            'pref_id' => $prefID,
            'value' => $value,
        );
 
        return $this->callMethod('data.setUserPreference', $args);
    }

    public function & setUserPreferences()
    {
        throw new Services_Facebook_Exception('not yet implemented');
    }

    public function & createObjectType($name) {
        $args = array(
            'name' => $name
        );

        return $this->callMethod('data.createObjectType', $args);
    }

    public function & dropObjectType($objType) {
        $args = array(
            'obj_type' => $objType
        );

        return $this->callMethod('data.dropObjectType', $args);
    }

    public function & renameObjectType($objType, $newName) {
        $args = array(
            'obj_type' => $objType,
            'new_name' => $newName,
        );

        return $this->callMethod('data.renameObjectType', $args);
    }

    public function & defineObjectProperty($objType, $propName, $propType) {
        // todo refactor into its own testable object
        if (is_int($propType)) {
            if (!($propType >= 1 && $propType <= 3)) {
                throw new Services_Facebook_Exception('prop_type is an ' .
                    'invalid integer: ' . $propType);
            }
        } else {
            $constName = 'self::_PROP_TYPE_' . strtoupper($propType);
            if (!defined($constName)) {
                throw new Services_Facebook_Exception('prop_type is not a ' .
                    'valid string: ' . $propType);
            }

            $propType = constant($constName);
        }

        $args = array(
            'obj_type' => $objType,
            'prop_name' => $propName,
            'prop_type' => $propType,
        );

        return $this->callMethod('data.defineObjectProperty', $args);
    }

    public function & undefineObjectProperty($objType, $propName) {
        $args = array(
            'obj_type' => $objType,
            'prop_name' => $propName,
        );

        return $this->callMethod('data.undefineObjectProperty', $args);
    }

    public function & renameObjectProperty($objType, $propName, $newName) {
        $args = array(
            'obj_type' => $objType,
            'prop_name' => $propName,
            'new_name' => $newName,
        );

        return $this->callMethod('data.renameObjectProperty', $args);
    }

    public function & getObjectTypes() {
        return $this->callMethod('data.getObjectTypes');
    }

    public function & getObjectType($objType) {
        $args = array(
            'obj_type' => $objType,
        );

        return $this->callMethod('data.getObjectType', $args);
    }

    public function & createObject($objType, array $properties = array()) {
        $args = array(
            'obj_type' => $objType,
        );
        if (count($properties) > 0) {
            $args['properties'] = json_encode($properties);
        }

        return $this->callMethod('data.createObject', $args);
    }

    public function & updateObject($objID, array $properties, $replace) {
        $args = array(
            'obj_id' => $objID,
            'properties' => json_encode($properties),
            'replace' => $replace ? 1 : 0,
        );

        return $this->callMethod('data.updateObject', $args);
    }

    public function & deleteObject($objID) {
        $args = array(
            'obj_id' => $objID,
        );

        return $this->callMethod('data.deleteObject', $args);
    }

    public function & deleteObjects(array $objIDs) {
        $args = array(
            'obj_ids' => json_encode($objIDs),
        );

        return $this->callMethod('data.deleteObjects', $args);
    }

    public function & getObject($objID, array $properties = array()) {
        if (count($properties) > 0) {
            throw new Services_Facebook_Exception('filtering by property name doesnot seem to work...');
        }
        $args = array(
            'obj_id' => $objID,
        );
        if (count($properties) > 0) {
            $args['properties'] = json_encode($properties);
        }
        return $this->callMethod('data.getObject', $args);
    }

    public function & getObjects(array $objIDs, array $properties = array()) {
        $args = array(
            'obj_ids' => json_encode($objIDs),
        );
        if (count($properties) > 0) {
            $args['properties'] = json_encode($properties);
        }

        return $this->callMethod('data.getObjects', $args);
    }

    public function & getObjectProperty($objId, $propName) {
        $args = array(
            'obj_id' => $objID,
            'prop_name' => $propName,
        );

        return $this->callMethod('data.getObjectProperty', $args);
    }

    public function & setObjectProperty($objID, $propName, $propValue) {
        $args = array(
            'obj_id' => $objID,
            'prop_name' => $propName,
            'prop_value' => $propValue,
        );

        return $this->callMethod('data.setObjectProperty', $args);
    }

    public function getHashValue() {
        throw new Services_Facebook_Exception(__METHOD__ . ' not yet implemented');
    }

    public function setHashValue() {
        throw new Services_Facebook_Exception(__METHOD__ . ' not yet implemented');
    }

    public function incHashValue() {
        throw new Services_Facebook_Exception(__METHOD__ . ' not yet implemented');
    }

    public function removeHashKey() {
        throw new Services_Facebook_Exception(__METHOD__ . ' not yet implemented');
    }

    public function removeHashKeys() {
        throw new Services_Facebook_Exception(__METHOD__ . ' not yet implemented');
    }
}

