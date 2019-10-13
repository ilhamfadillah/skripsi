<?php
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/config.php';

class UsahaModel
{
    public function __construct()
    {
        $this->conn = $GLOBALS['conn'];
        $this->user_table = "SELECT * FROM usaha_tables WHERE ";
    }
    public function get_all()
    {
        $sql = "SELECT usaha_tables.*, kecamatan_tables.nama as nama_kecamatan, kelurahan_tables.nama as nama_kelurahan FROM usaha_tables
        INNER JOIN kecamatan_tables on usaha_tables.kecamatan_id = kecamatan_tables.id 
        INNER JOIN kelurahan_tables on usaha_tables.kelurahan_id= kelurahan_tables.id";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function get_all_by_category($kategori)
    {
        $sql = "SELECT usaha_tables.*, kecamatan_tables.nama as nama_kecamatan, kelurahan_tables.nama as nama_kelurahan FROM usaha_tables
        INNER JOIN kecamatan_tables on usaha_tables.kecamatan_id = kecamatan_tables.id 
        INNER JOIN kelurahan_tables on usaha_tables.kelurahan_id= kelurahan_tables.id 
        where usaha_tables.kategori='" . $kategori . "'";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function get_row($params)
    {
        foreach ($params as $key => $value) {
            $data[] = "$key = '$value'";
        }
        $condition = implode(" and ", $data);
        $sql = $this->user_table." ".$condition." LIMIT 1";
        $result = $this->conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function get_all_kecamatan()
    {
        $sql = "SELECT id,nama FROM kecamatan_tables ORDER BY nama";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function get_all_kelurahan_by_kecamatan($kecamatan_id)
    {
        $sql = "SELECT id,nama  FROM kelurahan_tables WHERE kecamatan_id='" . $kecamatan_id . "' ORDER BY nama";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function create($data)
    {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $insert = $this->conn->query("INSERT INTO usaha_tables (".$columns.") VALUES (".$values.")");
        return mysqli_insert_id($this->conn);
    }

    public function count_by_category($kategori)
    {
        $sql = $this->conn->query("SELECT COUNT(id) as jumlah FROM usaha_tables WHERE kategori='".$kategori."'");
        return mysqli_fetch_assoc($sql)['jumlah'];
    }

    public function update($id, $data)
    {
        $array = [];
        foreach($data as $key=>$value){
            $array[] = $key."='".$value."'";
        }
        $set = implode(", ", $array);
        $insert = $this->conn->query("UPDATE usaha_tables set ".$set." WHERE id=".$id."");
    }

    public function delete($id){
        $deleteWisata = $this->conn->query("DELETE FROM wisata_tables WHERE usaha_id=".$id."");
        $deleteUsaha = $this->conn->query("DELETE FROM usaha_tables WHERE id=".$id."");
    }

    public function get_all_row_by_condition($params)
    {
        foreach ($params as $key => $value) {
            $data[] = "$key = '$value'";
        }
        $condition = implode(" and ", $data);
        $sql = $this->user_table." ".$condition;
        $result = $this->conn->query($sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
