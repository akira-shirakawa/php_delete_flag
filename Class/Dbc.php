<?php
ini_set('display_errors', 1);
require_once dirname(__FILE__).'/../env.php';

Class Db{
    protected $table_name;
    function __construct($table_name){
        $this->table_name = $table_name;
        $this->pdo = $this->dbc();
    }
    public function dbc(){

        try{
            $host =DB_HOST;
            $user =DB_USER;
            $password = DB_PASS; 
            $dbname = DB_NAME;
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=UTF8;", $user, $password); 
            return $pdo;
    
        }catch(PDOException $e){
          
        }
        
    }
    public function getMessage(){
        $sql = "select * from ".$this->table_name;
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
   
    public function getPagenate($id){
       
        $id = $id ?? 1;  
        $start = $id*3-3;
        

        $count_sql = "select count(*) from ".$this->table_name." where delete_flag = 0";
        $stmt = $this->pdo->query($count_sql);
        $count_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count_result = (int)$count_result['count(*)'];
        $oll_page = ceil($count_result/3);

        $sql = "select * from ".$this->table_name." where delete_flag = 0 limit $start,3";            
        $stmt = $this->pdo->prepare($sql);        
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return [$result,$oll_page];
        
    }
    public function search($search){
        $sql = "select * from log where (comment_id,created_at)  in (select comment_id, max(created_at) from log group by comment_id) and comment like '%$search%'";
        $stmt = $this->pdo->query($sql);            
        $search_result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $search_result;
    }
    public function select($str,$message_id){  
       
        if($str == 'all'){
            $sql = "select * from ".$this->table_name." where comment_id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$message_id]);
        }else{
            $sql = "select * from ".$this->table_name." where comment_id = ? and statue = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$message_id,$str]);
        }      
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
    public function show($id){
        $sql = "select * from ".$this->table_name." where id=?";
        $arr=[];
        $arr[]=$id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arr);   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    
    }
   public function getData($id,$column){
        $sql = "select * from ".$this->table_name." where $column =?"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;    
   }
   public function getDataNew($id,$column){
        $sql = "select * from ".$this->table_name." where $column =? order by id desc limit 1"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;   
   }
   public function getDataNext($id,$column){
        $sql = "select * from ".$this->table_name." where $column =? order by id  desc limit 1,1"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;   
   }
    public function create($array){
        $colum_name ='(';
        $value =[];
        $str='(';
        foreach ($array as $key=>$va){
            $colum_name = $colum_name.$key.',';
            $value[] = $va;
        }
        $colum_name = preg_replace("/.$/","",$colum_name);
        $colum_name = $colum_name.')';
        for($i=1;$i<=count($array);$i++){
            $str=$str.'?,';
        }
        $str = preg_replace("/.$/","",$str);
        $str = $str.')';
        $str = $colum_name.'values'.$str;
        $sql = "insert into $this->table_name".$str;
        var_dump($array);
        $stmt = $this->pdo->prepare($sql);
        var_dump($value);
        $result = $stmt->execute($value);
        return $result;       
    }
    public function delete($id){
        $sql = "delete from ".$this->table_name." where id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
       
    }
    
    
}
