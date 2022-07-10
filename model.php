<?php

define("ROOT", dirname(__FILE__));
require_once(ROOT.'/connect.php');

class Model {
    private $db;

    public function __construct() {
        $this->db = DataBase::getConnection();
    }

    public function getAllNurses() {
        $query = "SELECT * FROM nurse";
        $result = $this->db->prepare($query);
        $result->execute();
        return $result->fetchAll();
    }

    public function getWardByNurse($id) {
        $query = "SELECT wa.name FROM ward AS wa, nurse_ward AS nw WHERE nw.fid_nurse = :id AND wa.id_ward = nw.fid_ward";
        $result = $this->db->prepare($query);
        $result->bindParam('id', $id, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNurseDepatment($dep) {
        $query = "SELECT `name` FROM nurse WHERE department = :dep";
        $result = $this->db->prepare($query);
        $result->bindParam('dep', $dep, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDutyByShift($shift) {
        $query = "SELECT n.name, w.name FROM nurse AS n, nurse_ward AS nw, ward AS w WHERE n.shift = :shift AND n.id_nurse = nw.fid_nurse AND w.id_ward = nw.fid_ward";
        $result = $this->db->prepare($query);
        $result->bindParam('shift', $shift, PDO::PARAM_STR);
        $result->execute();

        return $result->fetchAll();
    }

    public function insertWard($ward) {
        $query = "INSERT INTO ward (`name`) VALUE (:ward)";
        $result = $this->db->prepare($query);
        $result->bindParam('ward', $ward, PDO::PARAM_STR);
        
        return $result->execute();
    }

    public function insertNurse($name, $date, $dep, $shift) {
        $query = "INSERT INTO nurse (`name`, `date`, `department`, `shift`) VALUE (:name, :date, :dep, :shift)";
        $result = $this->db->prepare($query);
        $result->bindParam('name', $name, PDO::PARAM_STR);
        $result->bindParam('date', $date, PDO::PARAM_STR);
        $result->bindParam('dep', $dep, PDO::PARAM_INT);
        $result->bindParam('shift', $shift, PDO::PARAM_STR);
        
        return $result->execute();
    }

    public function getWards() {
        $query = 'SELECT * FROM ward';
        $result = $this->db->prepare($query);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertNurseWard($idNurse, $idWard) {
        $query = 'INSERT INTO nurse_ward (fid_nurse, fid_ward) VALUE (:idNurse, :idWard)';
        $result = $this->db->prepare($query);
        $result->bindParam('idNurse', $idNurse, PDO::PARAM_INT);
        $result->bindParam('idWard', $idWard, PDO::PARAM_INT);

        return $result->execute();
    }
}

?>