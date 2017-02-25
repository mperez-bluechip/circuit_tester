<?php

  require_once(LIB_PATH.DS.'config.php');

  class Database {

    private $conn;

    function __construct{
      $this->open_conn();
    }

    public function open_conn(){
      $this->conn = mysqli_conn(DB_HOST, DB_USER, DB_PASS, DB_NAME);
      if(mysqli_errno()){
        die("Database failed to connect "
        . mysql_error();
        );
      }
    }

    public function close_conn(){
      if(isset($this->conn)){
        mysqli_close($this->conn);
        unset($this->conn);
      }

    }

    public function query($sql){
      $result = mysqli_query($this->conn, $sql);
      $this->confirm_query($result);
      return $result;
    }

    private confirm_query($result){
      if(!$result){
        die("Database query failed");
      }
    }

    public function escape_str($str){
      $escaped_str = mysqli_real_escape_string($this->conn, $str);
      return $escape_str;
    }

    public function fetch_array($result_set){
      return mysqli_fetch_array($result_set);
    }
    public function num_rows($result_set){
      return mysqli_num_rows($result_set);
    }
    public function affected_rows(){
      return mysqli_affected_rows($this->conn);
    }
    public function insert_id(){
      return mysqli_insert_id($this->conn);
    }


  }//database

  $db = new Database();
  $rdb = & $db;

?>
