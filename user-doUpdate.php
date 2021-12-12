<?php
require_once("pdo-connect.php"); //連線到遠端資料庫

$id=$_POST["id"];
$password=$_POST["password"];
$name=$_POST["name"];
$mobile=$_POST["mobile"];
$valid=$_POST["valid"];

if(isset($_POST["gender"])){
    $gender=$_POST["gender"];
//    var_dump($gender);
}else{
    $gender=null;
//    var_dump($gender);
}

if(isset($_POST["birthday"])){
    $birthday=$_POST["birthday"];
    if($birthday==""){
        $birthday=null;
    }
}else{
    $birthday=null;
}

if(isset($_POST["zip"])){
    $zip=$_POST["zip"];
    if($zip==""){
      $zip=null;
    }
}else{
    $zip=null;
}

if(isset($_POST["county"])){
    $county=$_POST["county"];
    if($county==""){
        $county=null;
    }
}else{
    $county=null;
}

if(isset($_POST["address"])){
    $address=$_POST["address"];
    if($address==""){
        $address=null;
    }
}else{
    $address=null;
}


$sqlUser="UPDATE users SET password=?, name=?, gender=?, birthday=?, mobile=?, zip_code=?, county=?, address=?, valid=?
WHERE id=?";
$stmtUser=$db_host->prepare($sqlUser);
try{
    $stmtUser->execute([$password, $name, $gender, $birthday, $mobile, $zip, $county, $address, $valid, $id]);
//    echo "修改資料完成<br>";
//    header("location: user.php?id=$id");
}catch(PDOException $e){
    echo $e->getMessage();
}

if ($_FILES["myFile"]["error"] === 0){
    $fileExt=pathinfo($_FILES["myFile"]["name"], PATHINFO_EXTENSION);
    if (move_uploaded_file($_FILES["myFile"]["tmp_name"], "images/".$id."-".time().".".$fileExt)){
        $file_name=$id."-".time().".".$fileExt;

        $sqlPic="UPDATE users SET image=? WHERE id=? ";
        $stmtPic=$db_host->prepare($sqlPic);
        try{
            $stmtPic->execute([$file_name, $id]); //寫入資料庫
//            echo "upload success";
            echo "<script> alert('修改成功!'); window.location.href='user.php?id=$id'</script>";
        }catch (PDOException $e){
            echo $e->getMessage();
        }
    }else{
        echo "upload failed";
    }
}else{
    echo "<script> alert('修改成功!'); window.location.href='user.php?id=$id'</script>";
}