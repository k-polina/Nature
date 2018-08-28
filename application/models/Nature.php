<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nature extends CI_Model {
    // returns user id and name, search by email
    public function findUser($postemail) {
        $query = "SELECT users.id, users.name FROM users WHERE email = ?;";
        return $this->db->query($query, $postemail)->row_array();
    }

    // returns locations and sq meters for certain user, search by user id
    public function findCoordinates($userid) {
        $query = "SELECT location.latitude, location.longitude, location.id, users_has_location.sqm
        FROM location
        INNER JOIN users_has_location
        ON users_has_location.location_id = location.id
        WHERE users_has_location.users_id = ?";
        return $this->db->query($query, $userid)->result_array();
    }

    // returns all images and videos for certain location, search by location id
    public function findMedia($locationid) {
        $query = "SELECT media.link
        FROM media
        WHERE media.location_id = ?";
        return $this->db->query($query, $locationid)->result_array();
    }

    public function getCoordinates($locationid) {
        $query = "SELECT location.latitude, location.longitude, users_has_location.sqm
        FROM location
        INNER JOIN users_has_location
        ON users_has_location.location_id = location.id
        WHERE location.id = ?";
        return $this->db->query($query, $locationid)->row_array();
    }

    public function calculateSqm($userid) {
        $query = "SELECT SUM(sqm) AS sum
        FROM users_has_location
        WHERE users_id = ?";
        return $this->db->query($query, $userid)->row_array();
    }
}