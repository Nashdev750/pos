<?php


class db{
    // private $host = "localhost";
    // private $user = "pos";
    // private $pass = "Nashdev@098";
    // private $db = "pos";
    // private $con = null;
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "pos";
    private $con = null;

    public function __construct(){
        // $this->db = $_SESSION['user']['dbname'];
       
        $str = "mysql:host=".$this->host.";dbname=".$this->db;
        try{
            $this->con = new PDO($str,$this->user,$this->pass);
        }catch(PDOException $x){
           echo $x->getMessage();
        }
     
       
    }
    //insert/update/delete
    public function writedb($sql,$arr=array()){
       $stmt = $this->con->prepare($sql);
       try{
        $stmt->execute($arr);
        $count= $this->con->lastInsertId();
        return $count;
       }catch(PDOException $e){
           return $e->getMessage();
       }
    }
    //get age function
    public function age($dob)
    {
      $yr =  explode("-", $dob);

       return ((intval(date("Y")))- (intval($yr[0])));

    }
   
    public function readdb($sql,$arr=array()){
        $stmt = $this->con->prepare($sql);
        try{
         $stmt->execute($arr);
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function readdbone($sql,$arr=array()){
        $stmt = $this->con->prepare($sql);
        try{
         $stmt->execute($arr);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function readdbrow($sql,$arr=array()){
        $stmt = $this->con->prepare($sql);
        try{
         $stmt->execute($arr);
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $stmt->rowCount();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function readname($sql,$col,$arr=array()){
        $stmt = $this->con->prepare($sql);
        try{
         $stmt->execute($arr);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);
         return $result[$col];
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }
 
function readmsg($sql,$arr=array()){
    $stmt = $this->con->prepare($sql);
    try{
     $stmt->execute($arr);
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     return $result;
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}
    public function login($user,$password,$sql,$doc){
        
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['user'=>$user]);
        $reslt = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $count =  $stmt->rowCount();
        if($count==0){
            return 1;
        }elseif($count ==1){
           foreach($reslt as $user){
            $pass = $user['password'];
            if(password_verify($password,$pass)){
                 session_start();
                 if($doc=="1"){
                    return $_SESSION['doc'] = $user['id'];
                 }elseif($doc=="0"){
                    return $_SESSION['user'] = $user['id'];
                 }
               
                
            }else{
                return 1;
            }
           }  
        }else{
            return 1;
        }
    }

    public function loginadmin($user,$password){
        $sql = "SELECT * FROM `users` WHERE `username`=:user";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['user'=>$user]);
        $reslt = $stmt->fetch(PDO::FETCH_ASSOC);
        $count =  $stmt->rowCount();
        if($count==0){
            return 1;
        }elseif($count ==1){
           
            $pass =   $reslt['password'];
            if(password_verify($password,$pass)){

                    $_SESSION['user'] = $reslt;
                 
            }else{
                return 1;
            }
           
        }else{
            return 1;
        }
    }
    public function upload($file,$path){
        if(!empty($file['name'])){
            
            //,'NEF','nef','mp4','MP4','mkv','MKV'
            $ext = array('jpg','png','jpeg','JPEG','JPG','PNG');
            $name = $file['name'];
            $extens = explode(".",$name);
        
            if(!in_array($extens[1],$ext)){
              
              return 3;
            }elseif(in_array($extens[1],$ext)){
            
            $newname = uniqid(time()).$extens[0].".".$extens[1];
            if(move_uploaded_file($file['tmp_name'],$path.$newname)){
              return $newname;
            }else{
              return 3;
            }
        }
     }else{
    
         return 3;
     }
    }

public function uploadimg($file,$path){
    if(!empty($file['name'])){
        
        //,'NEF','nef','mp4','MP4','mkv','MKV'
        $ext = array('jpg','png','jpeg','JPEG','JPG','PNG');
        $name = $file['name'];
        $extens = explode(".",$name);
    
        if(!in_array($extens[1],$ext)){
          
          return 3;
        }elseif(in_array($extens[1],$ext)){
        
        $newname = uniqid(time()).$extens[0].".".$extens[1];
        $dest =  $this->compressimage($file['tmp_name'],$path.$newname,60);
        if($dest){
           
               return $newname;
           
        }else{
          return 3;
        }
    }
 }else{

     return 3;
 }
}

//compress image
public function compressimage($source,$path,$size){
    $info = getimagesize($source);
  
    $image = ($info['mime']== 'image/jpeg' || $info['mime']=='image/webp')?imagecreatefromjpeg($source):imagecreatefrompng($source);
    // if($info['mime']== 'image/jpeg'){
    //     $image = imagecreatefromjpeg($source);
    // }elseif($info['mime']== 'image/png'){
    //     $image = imagecreatefrompng($source);
    // }
    imagejpeg($image,$path,$size);
    return $path;
}


// user location
public function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
      return 0;
    }
    else {
      $theta = $lon1 - $lon2;
      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      $miles = $dist * 60 * 1.1515;
      $unit = strtoupper($unit);
  
      if ($unit == "K") {
        return ($miles * 1.609344);
      } else if ($unit == "N") {
        return ($miles * 0.8684);
      } else {
        return $miles;
      }
    }
  }

}
$sql = `SELECT 111.111
* DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.Latitude))
* COS(RADIANS(b.Latitude))
* COS(RADIANS(a.Longitude - b.Longitude))
+ SIN(RADIANS(a.Latitude))
* SIN(RADIANS(b.Latitude))))) AS distance_in_km`;