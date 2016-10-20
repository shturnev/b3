<?php
class DB
{
    private $connect_settings = [
                                      "host"  => "127.0.0.1"
                                    , "login" => "test"
                                    , "pass"  => 123
                                    , "db"    => "b3"
                                ];

    private $db_connect;


    public function __construct()
    {

    }


    private function connect()
    {
        if($this->db_connect->ping()){ return $this->db_connect; } //false

        $mysqli = new mysqli($this->connect_settings["host"], $this->connect_settings["login"], $this->connect_settings["pass"], $this->connect_settings["db"]);
        if($mysqli->connect_errno){
            exit($mysqli->connect_error);
        }

        $this->db_connect = $mysqli;

        return $mysqli;
    }



    public function insert($table, $arr, $close = false){

        if(!$this->db_connect->ping()){
            $this->connect();
        }

        $keys = array_keys($arr);
        $values = array_values($arr);

        $resInsert = $this->db_connect->query("INSERT INTO ".$table." (".implode(",", $keys).") VALUES ('".implode("','", $values)."')");

        if(!$resInsert){
            $result["error"] = $this->db_connect->errno;
            $result["error_text"] = $this->db_connect->error;
        }

        $result["result"] = $resInsert;

        //закрываем соединение с бд
        if($close){
            $this->db_connect->close();
        }


        //response
        return $result;
    }


    public function update($table, $arr, $where, $close = false)
    {


        if (!$this->db_connect->ping()) {
            $this->connect();
        }

            $newArr = [];
            foreach ($arr as $key => $value) {
                $newArr[] = $key . "='" . $value . "'";
            }


            $resUpdate = $this->db_connect->query("UPDATE " . $table . " SET " . implode(",", $newArr) . " WHERE " . $where);
            if (!$resUpdate) {
                $result["error"] = $this->db_connect->errno;
                $result["error_text"] = $this->db_connect->error;
            }
            $result["result"] = $resUpdate;

            //закрываем соединение с бд
            if($close){
                $this->db_connect->close();
            }

            return $result;



    }


    public function delete($table, $where, $close = false)
    {

        if(!$this->db_connect->ping()){
            $this->connect();
    }


        $resdelete = $this->db_connect->query("DELETE FROM ".$table." WHERE ".$where);
        if(!$resdelete){
            $result["error"] = $this->db_connect->errno;
            $result["error_text"] = $this->db_connect->error;
        }
        $result["result"] = $resdelete;

        //закрываем соединение с бд
        if($close){
            $this->db_connect->close();
        }

        //response
        return $result;
    }


    public function select($sql, $close = false){

        if(!$this->db_connect->ping()) {
            $this->connect();
        }

        $resselect = $this->db_connect->query($sql);
        if(!$resselect){
            $result["error"] = $this->db_connect->connect_errno;
            $result["error_text"] = $this->db_connect->connect_error;
        }
        else
        {
            $result["result"] = $resselect->fetch_all(MYSQLI_ASSOC);
        }


        //закрываем соединение с бд
        if($close){
            $this->db_connect->close();
        }

        //response
        return $result;
    }
}