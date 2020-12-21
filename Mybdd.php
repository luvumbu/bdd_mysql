<?php
header("Access-Control-Allow-Origin: *");
class Mybdd { 
  private $Connect_value=false;
  private $servername ;
  private $dbname;
  private $username ;
  private $password ; 
  private $conn;
  private $table;
  private $array_table=array();
  private $liste_table="";
  private $insert_name="";
  private $insert_value="";
  private $insert_select;

  private $select_sql;
  private $select_row_name= array();
  private $select_row_value= array();
  private $row_all_boolean=false;
  

function __construct($servername,$dbname,$username,$password) {
    $this->servername = $servername; 
    $this->dbname =     $dbname; 
    $this->username =   $username; 
    $this->password =   $password; 
    // initialisation des variable pour la connexion de la bdd 
  }
function set_servername($servername){
  $this->servername= $servername;
}
function set_dbname($dbname){
  $this->dbname= $dbname;
}
function set_username($username){
  $this->username= $username;
}
function set_conn($conn){
  $this->conn=$conn;
}
function set_password($password){
  $this->password= $password;
}
function set_name_table($table){
  $this->table= $table;
}
function set_array_table($value){
  array_push($this->array_table,$value);
}
function set_insert_name($insert_name){
$this->insert_name= $insert_name;
}
function set_insert_value($insert_value){
$this->insert_value= $insert_value;
}
function set_insert_select($select){
$this->insert_select = $select;
}
function set_select_sql($select){ 
 $this->select_sql= $select;
  }
  function set_select_row_name($select){ 
    array_push($this->select_row_name, $select);
    }


    function set_select_row_value($select){ 
      array_push($this->select_row_value, $select);
      }
    





function get_servername(){
return $this->servername;
}
function get_dbname(){
return $this->dbname;
}
function get_username(){
 return $this->username;
}
function get_password(){
  return $this->password;
}
function merge_row(){
//$this->row= array_merge($this->select_row_value,$this->select_row_name);
 
$this->row =array_combine($this->select_row_name,$this->select_row_value);
print_r($this->row );

}
 
function get_table(){
  return $this->table;
}

function get_row($name){
  
 
    return $this->row[$name];
 
}
function get_row_all(){
 
 
    return $this->row;

  
  
}

function get_array_table($number){ 
 return $this->array_table[$number];
 // donne la valeur demande du table en question
} 
function count_array_table(){
  return count($this->array_table);
  // donne le nombre execte des valeur dans le tableau
}
function count_select_row_name(){
  return count($this->select_row_name);
}

function count_select_row_value(){
  return count($this->select_row_value);
}





function get_insert_name(){
return $this->insert_name;
}
function get_insert_value(){
return $this->insert_value;
}
function get_insert_select(){
  return $this->insert_select ;
  }
  function select_info(){
  }

  function get_select_sql($select){ 
    
    return $this->select_sql[$select];
    }
    function get_select_row_name($select){
   
      return $this->select_row_name[$select];
      }
      function get_select_row_value($select){
   
        return $this->select_row_value[$select];
        }

      
    
function insert_data($information_data){
  
 // Create connection
$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = $information_data;

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
 
} 



function Connect(){
    try {
      $this->conn=new PDO("mysql:host=$this->servername;dbname=".$this->dbname, $this->username, $this->password);       
      // set the PDO error mode to exception
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      echo "Connected successfully";
      $this->Connect_value=true;
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      $this->Connect_value=false;
    }
 
  }




  function createtable(){
    $this->Connect();
if( $this->Connect_value==true){
 
  

// Create connection
$conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// sql to create table


$this->count_array_table(); 
 
 
for($i=0;$i<$this->count_array_table();$i++){   
  //echo $this->get_array_table($i);   
  $this->liste_table = $this->liste_table.$this->get_array_table($i);  
}

$sql = "CREATE TABLE $this->table ($this->liste_table)";

if ($conn->query($sql) === TRUE) {
  echo "Table MyGuests created successfully";
} else {
  echo "Error creating table: " . $conn->error;
}

$conn->close();

}
else{
  echo "une erreur rencontre";
}
  }

function select_sql(){
  $this->Connect();
  if( $this->Connect_value==true){
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
        // sql to create table 
$sql = $this->select_sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
  //  echo "	firstname: " . $row["firstname"]."<br/>";
  echo "<br/>";
  echo "count ici <br/>".$this->count_select_row_name();
  // foreache debut
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
for($i=0;$i<$this->count_select_row_name();$i++){
  //echo "<strong>".$this->get_select_row_name($i)."</strong><br/>"; 
  $this->set_select_row_value($row[$this->get_select_row_name($i)]);
}
$this->merge_row();
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  // foreach fin
  }
} else {
  echo "0 results";
}
$conn->close();    
  }
} 
// insert si lelement nexiste pas !!!! 
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
function insert_sql($element){
  $this->Connect();
  if( $this->Connect_value==true){
    // Create connection
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
        // sql to create table 
$sql = $this->select_sql;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) { 
  }
} else {
  echo "0 results pas de resultat  ok 00 zero";
  $sql =$element;
  
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();

}
   
  }
}
//§!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
} 
