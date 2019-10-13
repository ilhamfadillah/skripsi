<?php
require $_SERVER['DOCUMENT_ROOT'].'/skripsi/config.php';

class UserModel
{
    public function __construct()
    {
        $this->conn = $GLOBALS['conn'];
        $this->user_table = "SELECT * FROM user_tables WHERE ";
    }
    public function get_all()
    {
        $sql = "SELECT * FROM user_tables";
        $result = $this->conn->query($sql);
        $rows = [];
        while ($row = mysqli_fetch_array($result)) {
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
}
