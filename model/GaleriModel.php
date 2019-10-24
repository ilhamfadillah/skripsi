<?php
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/config.php';

class GaleriModel
{
    public function __construct()
    {
        $this->conn = $GLOBALS['conn'];
        $this->galeri_table = "SELECT * FROM galeri_tables WHERE ";
    }

    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $insert = $this->conn->query("INSERT INTO galeri_tables (".$columns.") VALUES (".$values.")");
        return mysqli_insert_id($this->conn);
    }

    public function get_one_row_by_usaha_id($usaha_id)
    {
        $sql = $this->galeri_table." usaha_id=".$usaha_id;
        $result = $this->conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function get_all_row_by_condition($params)
    {
        foreach ($params as $key => $value) {
            $data[] = "$key = '$value'";
        }
        $condition = implode(" and ", $data);
        $sql = $this->galeri_table." ".$condition;
        $result = $this->conn->query($sql);
        if($result->num_rows != 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }else{
            $rows = [];
        }
        return $rows;
    }

    public function get_all_row_by_usaha_id($usaha_id)
    {
        $sql = $this->galeri_table." usaha_id='".$usaha_id."'";
        $result = $this->conn->query($sql);
        if($result->num_rows != 0){
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }else{
            $rows = [];
        }
        return $rows;
    }

    public function delete_by_condition($params)
    {
        foreach ($params as $key => $value) {
            $data[] = "$key = '$value'";
        }
        $condition = implode(" and ", $data);
        $sql = "DELETE FROM galeri_tables WHERE " . $condition;
        $result = $this->conn->query($sql);
    }
}
