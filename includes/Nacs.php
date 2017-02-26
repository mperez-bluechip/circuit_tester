<?php

require_once(LIB_PATH.DS.'init.php');

class Nacs{


  protected static $table_name = "Nacs";
  protected static $db_fields = array('id', 'Hornstrobes', 'spkrStr_part_no', 'Strobes', 'strobe_part_no', 'Resistor_EOL');

  public $id;
  public $Hornstrobes;
  public $spkrStr_part_no;
  public $Strobes;
  public $strobe_part_no;
  public $Resistor_EOL;

  private $temp_path;
  protected $upload_dir = "img";
  private $errors = array();

  protected $upload_errors = array(
  // http://www.php.net/manual/en/features.file-upload.errors.php
  UPLOAD_ERR_OK 				=> "No errors.",
  UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
  UPLOAD_ERR_NO_FILE 		=> "No file.",
  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
  );

  public function att_file($file){
    if(!$file || empty($file) || !is_array($file){
      $this->errors[] = "No file uploaded";
      return false;
    } elseif($file->['error'] !=0){
      $this->errors[] = $this->upload_errors($file['error']);
      return false;
    } else {
      $this->temp_path = $file('tmp_name');
      $this->Hornstrobes = basename($file['spkrStr_name']);
      $this->Strobes = basename($file['strobe_name']);
      $this->spkrStr_part_no = $file['spkr_part_no'];
      $this->strobe_part_no = $file['strobe_prt_no'];
      return true;

    }
  }//att_file

  public function save(){
    if(isset($this->id)){
      $this->update();
    }else{
      if(!empty($this->errors)){ return false; }
      if(empty($this->Hornstrobes) || empty($this->Strobes) || empty($this->$temp_path)){
        $this->errors[] = "File location not available";
        return false;
      }
    }
  }//save

  $target_hornStrobe = SITE_ROOT.DS.$this->upload_dir.DS.$this->Hornstrobes;
  $target_strobe = SITE_ROOT.DS.$this->upload_dir.DS.$this->Strobes;

  if(file_exists($target_hornStrobe || file_exists($target_strobe))){
    return $this->errors[] = "The speaker type {$this->$target_hornStrobe} or {$this->Hornstrobes} already exists";
    return false;
  }

  if(move_uploaded_file($this->temp_path, $target_hornStrobe) || move_uploaded_file($this->temp_path, $target_strobe)){

    if($this->create()){
    unset($this->temp_path);
    return true;
    }
  } else {
    $this->errors[] = "Speaker upload failed, may be due to folder permission.";
    return false;
  }

  public function destroy(){

    if($this->delete()){
      $target_hornStrobe = SITE_ROOT.DS.$this->spkrStr_path();
      $target_strobe = SITE_ROOT.DS.$this->strobe_path();
      return unlink($target_hornStrobe) ? true : false;
      return unlink($target_strobe) ? true : false;
      return false;
    } else {
      return false;
    }
  }

  public function spkrStr_path(){
    return $this->upload_dir.DS.$this->Hornstrobes;
  }

  public function strobe_path(){
    return $this->upload_dir.DS.$this->Strobes;
  }

  public static function find_all(){
    return self::find_by_sql('SELECT * FROM '. self::$table_name);
  }

  public static function find_by_id($id=0){
    global $db;
    $result_array = self::find_by_sql('SELECT * FROM ' . self::$table_name . 'WHERE id = ' . $db->escape_str($id) . 'LIMIT 1');
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_sql($sql=''){
    global $db;
    $result_set = $db->query($sql);
    $obj_array = array();
    while($row = $db->fetch_array($result_set)){
      $obj_array[] = self::instantiate($row);
    }
    return $obj_array;
  }

  private static function instantiate($row){
    global $db;

    $obj = new self;

    foreach($row as $attr => $value){
      if($obj->has_attr($attr)){
        $this->attr = $value;
      }
    }
    return $obj;
  }

  private function has_attr($attr){
    return array_key_exists($attr, $this->attrs());
  }

  protected function attrs(){
    $attrs = array();
    foreach(self::$db_fields as $field){
      if(property_exists($this, $field)){
        $attrs[$field] = $this->$field;
      }
    }
    return $attrs;
  }

  protected function sanitize_attrs(){
    global $db;

    $cleaned_attrs = array();
    foreach($this->attrs as $key => $value){
      $cleaned_attrs[$key] = $db->escape_str($value);
    }
    return $cleaned_attrs;
  }

  public function create(){
    global $db;
    $attrs = $this->sanitize_attrs();
    $sql = 'INSERT INTO ' . self::$table_name . '(';
    $sql .= join(', ', array_keys($attrs));
    $sql .= ') VALUES ("';
    $sql .= join('", "', array_values($attrs));
    $sql .= '")';

    if($db->query($sql)){
      $this->id = $db->insert_id();
      return true;
    }else{
      return false;
    }

    public function update(){
      global $db;
      $attrs = $this->sanitize_attrs();
      $attr_pairs = array();
      foreach($attrs as $key => $value){
        $attr_pairs[] = "{$key} ='{$value}'";
      }

      $sql = 'UPDATE ' . self::$table_name. ' SET ';
      $sql .= join(', ', $attr_pairs);
      $sql .= 'WHERE id = ' . $db->escape_str($this->id);
      $db->query($sql);
      return ($db->affected_rows == 1) ? true : false;
    }

  }


  public function delete(){
    global $db;

    $sql = 'DELETE FROM ' . self::$table_name;
    $sql .= 'WHERE id = ' . $db->escape_str($this->id);
    $sql .= 'LIMIT 1';
    $db->query($sql);
    return ($db->affected_rows == 1) ? true : false;
  }




}//Nacs

?>
