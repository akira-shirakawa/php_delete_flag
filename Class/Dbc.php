<?php
ini_set('display_errors', 1);
require_once dirname(__FILE__).'/../env.php';

Class Db{
    protected $table_name;
    function __construct($table_name){
        $this->table_name = $table_name;
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
        $stmt = $this->dbc()->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getLog(){
        $sql = "select * from ".$this->table_name;
        $stmt = $this->dbc()->query($sql);
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        $str_result =[];
        foreach($result as $value){
            $id = $value['id'];
            $comment = $value['comment'];
            $comment_old = $value['comment_old'];
            $update = $value['created_at'];
            if($value['delete_flag'] == 1){
                $str_result[]= "<tr class='has-background-danger'><td>$id</td><td>削除</td><td>$comment_old</td><td>$comment</td><td>$update</td></tr>";
            }elseif($value['delete_flag'] == 0 && $comment_old){
                $str_result[]  = "<tr class='has-background-link'><td>$id</td><td>更新</td><td>$comment_old</td><td>$comment</td><td>$update</td></tr>";

            }else{
                $str_result[] = "<tr class='has-background-primary'><td>$id</td><td>新規作成</td><td>$comment_old</td><td>$comment</td><td>$update</td></tr>";

            }
        }
       return $str_result;
    }
    public function getPagenate($id){
       
        $id = $id ?? 1;  
        $start = $id*3-3;
        

        $count_sql = "select count(*) from ".$this->table_name." where delete_flag = 0";
        $stmt = $this->dbc()->query($count_sql);
        $count_result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count_result = (int)$count_result['count(*)'];
        $oll_page = ceil($count_result/3);

        $sql = "select * from ".$this->table_name." where delete_flag = 0 limit $start,3";            
        $stmt = $this->dbc()->prepare($sql);        
        $stmt->execute();
        $result = $stmt->fetchall(PDO::FETCH_ASSOC);
        return [$result,$oll_page];
        
    }
    public function search($search){
        $sql = "select * from ".$this->table_name." where comment like '%$search%'";
        $stmt = $this->dbc()->query($sql);            
        return $search_result = $stmt->fetchall(PDO::FETCH_ASSOC);
    }
    public function show($id){
        $sql = "select * from ".$this->table_name." where id=?";
        $arr=[];
        $arr[]=$id;
        $stmt = $this->dbc()->prepare($sql);
        $stmt->execute($arr);   
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    
    }
   public function getData($id,$column){
        $sql = "select * from ".$this->table_name." where $column =?"; 
        $stmt = $this->dbc()->prepare($sql);
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
        $stmt = $this->dbc()->prepare($sql);
        var_dump($value);
        $result = $stmt->execute($value);
        return $result;       
    }
    public function delete($id){
        $sql = "delete from ".$this->table_name." where id = ?";
        $stmt = $this->dbc()->prepare($sql);
        $stmt->execute([$id]);
       
    }
    
    
}
