<?php

  require_once(LIB_PATH.DS.'config.php');

  class Database {

    private $conn;

    function __construct(){
      $this->open_conn();
    }

    public function open_conn() {
    $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(mysqli_connect_errno()) {
      die("Database connection failed: " .
           mysqli_connect_error() .
           " (" . mysqli_connect_errno() . ")"
      );
    }
  }

  public function close_connection() {
  if(isset($this->conn)) {
    mysqli_close($this->conn);
    unset($this->conn);
  }
}

  public function query($sql) {
  $result = mysqli_query($this->conn, $sql);
  $this->confirm_query($result);
  return $result;
  }

  private function confirm_query($result) {
    if (!$result) {
      die("Database query failed.");
    }
  }

  public function escape_value($str) {
  $escaped_str = mysqli_real_escape_string($this->conn, $str);
  return $escaped_str;
}

  public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set);
  }

  public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }

  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }

  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }


  }//database

  $db = new Database();
  $rdb = & $db;

?>
