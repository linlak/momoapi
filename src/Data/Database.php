<?php
namespace  Momo\MomoApp\Data;
use \PDO;
abstract class Database{
	private $stmt;
    private $dbh;
    private $error;
	
	 public function __construct($host,$dbName,$dbUser,$dbPass) {
		
        // Set DSN
        $dsn = sprintf('mysql:host=%s;dbname=%s', $host, $dbName);
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $dbUser, $dbPass, $options);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }
	public function query($query){
    $this->stmt = $this->dbh->prepare($query);
	}
	public function newtable($sql){
        $this->stmt = $this->dbh->exec($sql);
	}
	public function bind($param, $value, $type = null){
    if (is_null($type)) {
        switch (true) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
    }
    $this->stmt->bindValue($param, $value, $type);
	}
	public function execute(){
        return $this->stmt->execute();
	}
	public function resultset(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public function single(){
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}
	public function rowCount(){
    return $this->stmt->rowCount();
	}
	public function lastInsertId(){
    return $this->dbh->lastInsertId();
	}
	public function beginTransaction(){
    return $this->dbh->beginTransaction();
	}
	public function endTransaction(){
    return $this->dbh->commit();
	}
	public function cancelTransaction(){
    return $this->dbh->rollBack();
	}
	public function debugDumpParams(){
    return $this->stmt->debugDumpParams();
	}
	final public function retdata($retsql,$values=NULL){
    
        $this->query($retsql);
        $this->execute($retsql);
        if(is_null($values)){
            $ret=$this->single($retsql);
        }elseif($values==='all'){
            $ret=$this->resultset($retsql);
        }       
        return $ret;
    }
    
    // dynamically insert single row
    final public function genInsert($tableName,$myarray){
        if(empty($tableName)||empty($myarray)){
            return false;
        }
        foreach($myarray as $key=>$value){
            $colmns[]=$key;
            $tobind[]=':'.$key;
            $values[]=$value;
    
        }
        $colmns_list=join(',',$colmns);
        $param_list=join(',',array_map(function($col){return ":$col";},$colmns));
        $sql="INSERT INTO $tableName ($colmns_list) VALUES ($param_list)";
        $this->query($sql);
        for($i=0;$i<count($tobind);$i++){
            $this->bind($tobind[$i],$values[$i]);
        }
        return $this->execute();
    }
    // dynamically update single row
    final public function genUpdate($tableName,array $cols,$whereArgs=array(),$lim=1){
        if(empty($tableName)||empty($cols)){
            return false;
        }
        $tobind=$colmns=$values=$wherecols=array();
        foreach($cols as $key=>$value){
            $colmns[]=$key.'=:'.$key;
            $tobind[]=':'.$key;
            $values[]=$value;
    
        }
        foreach ($whereArgs as $key => $value) {
            $wherecols[]=$key.'=:'.$key;
            if (!in_array($key, $tobind)) {
                $tobind[]=':'.$key;
                $values[]=$value;
            }
        }
        $where_list=join(' AND ',$wherecols);
        $param_list=join(', ',$colmns);
        $sql="UPDATE $tableName SET $param_list ";
        if (!empty($wherecols)) {
           $sql.=" WHERE $where_list ";
        }        
        $sql.=" LIMIT {$lim}";
        $this->query($sql);
        for($i=0;$i<count($tobind);$i++){
            $this->bind($tobind[$i],$values[$i]);
        }
        // $this->debugDumpParams();
        return $this->execute();
    }
    // dynamically insert multiple rows
    final public function insertMultipleRows($tableName,$data){ 
        // will contain SQL snippets
        $rowsSQL=array();
        //will contain the values that we neen to bind 
        $tobind=array();
        // get list of column names to use in sql statement
        $columnNames=array_keys($data[0]);
    
        // loop thru data array
        foreach($data as $arrayIndex=>$row){
            $params=array();
            foreach($row as $columnName=>$columnValue){
                $param=":".$columnName.$arrayIndex;
                $params[]=$param;
                $tobind[$param]=$columnValue;
            }
            $rowsSQL[]="(".join(",",$params).")";
        }
    
        // our sql statement
        $colmns_list=join(',',$columnNames);
        //placeholders for each row
        $param_list=join(',',$rowsSQL);
        // $param_list;
        $sql="INSERT INTO $tableName ($colmns_list) VALUES $param_list";
        // prepare our pdo statement
        $this->query($sql);
        foreach($tobind as $param=>$val){
            $this->bind($param,$val);
        }
        return $this->debugDumpParams();
        // return $this->execute();
    }
    final function genDelete($tableName,$whereArgs,$lim=0){
        if (empty($tableName)) {
            return false;
        }
        $tobind=$values=$wherecols=array();
         foreach ($whereArgs as $key => $value) {
            $wherecols[]=$key.'=:'.$key;
                $tobind[]=':'.$key;
                $values[]=$value;            
        }
        $where_list=join(' AND ',$wherecols);
        $sql="DELETE FROM $tableName ";
        if (!empty($wherecols)) {
           $sql.=" WHERE $where_list ";
        }
        if ($lim>0) {
            $sql.=" LIMIT {$lim}";    
         }     
        
        $this->query($sql);
        for($i=0;$i<count($tobind);$i++){
            $this->bind($tobind[$i],$values[$i]);
        }
        // $this->debugDumpParams();
        return $this->execute();
    }
    // dynamically execute queries that require no data returned
    final public function putdata($retsql){
    $this->query($retsql);  
    return $this->execute($retsql); 
    }
	// fetch dynamic data 
	function findfield_by_value($tableName, $columnName,$value, $columnName1=NULL, $value1=NULL){
	
	$sql = "SELECT * ";
	$sql .="FROM $tableName ";
	$sql .="WHERE $columnName = '$value' ";
	if($columnName1!=NULL && $value1!=NULL){
		$sql .="AND $columnName1= ':value1' ";
	}
	$sql .="LIMIT 1";	
	$this->query($sql);
	$this->bind(':value',$value);
	if($columnName1!=NULL && $value1!=NULL){
		$this->bind(':value1',$value1);
	}
	 $find_rows = $this->single();
	 if( $find_rows){
		 return $find_rows;
		 }else{
			 return null;
		 }
	
	}
	}