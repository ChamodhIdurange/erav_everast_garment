<?php
session_start();
if(!isset($_SESSION['userid'])){header ("Location:index.php");}
require_once('../connection/db.php');//die('bc');
$userID=$_SESSION['userid'];

$recordOption=$_POST['recordOption'];
if(!empty($_POST['recordID'])){$recordID=$_POST['recordID'];}
$catalogcat = $_POST['catalogcat'];
$product = $_POST['product'];
$uom = $_POST['uom'];
$type = $_POST['type'];
$updatedatetime=date('Y-m-d h:i:s');
$today=date('Y-m-d');
// Product Image
if(!empty($_FILES["productimage"]["name"])){
    $error=array();
    $extension=array("jpeg","jpg","png","gif","JPEG","JPG","PNG","GIF"); 
    $target_path = "../images/uploads/catalogitem/";

    $imageRandNum=rand(0,100000000);

    $file_name=$_FILES["productimage"]["name"];
    $file_tmp=$_FILES["productimage"]["tmp_name"];
    $ext=pathinfo($file_name,PATHINFO_EXTENSION);

    if(in_array($ext,$extension)){
        if(!file_exists("../images/uploads/catalogitem/".$file_name)){
            $filename=basename($file_name,$ext);
            $newFileName=md5($filename).date('Y-m-d').date('h-i-sa').$imageRandNum.".".$ext;
            move_uploaded_file($file_tmp=$_FILES["productimage"]["tmp_name"],"../images/uploads/catalogitem/".$newFileName);
            $image_path=$target_path.$newFileName;
        }
        else{
            $filename=basename($file_name,$ext);
            $newFileName=md5($filename).date('Y-m-d').date('h-i-sa').$imageRandNum.time().".".$ext;
            move_uploaded_file($file_tmp=$_FILES["productimage"]["tmp_name"],"../../images/uploads/catalogitem/".$newFileName);
            $image_path=$target_path.$newFileName;
        }
        $productimagepath=substr($image_path,3);
    }
    else{
        array_push($error,"$file_name, ");
    }
}

if($recordOption==1){
    $query = "INSERT INTO `tbl_catalog`(`uom`, `group_type`, `tbl_catalog_category_idtbl_catalog_category`, `tbl_product_idtbl_product`, `tbl_user_idtbl_user`, `imgpath`, `status`, `inserdatetime`) Values ('$uom ','$type','$catalogcat','$product','$userID','$productimagepath','1','$updatedatetime')";
    if($conn->query($query)==true){
        
        header("Location:../productcatalog.php?action=4");
    }
    else{header("Location:../productcatalog.php?action=5");}
}
else{
    echo $productimagepath;
    if($productimagepath!=''){
        $query = "UPDATE `tbl_catalog` SET `uom`='$uom',`group_type`='$type',`tbl_catalog_category_idtbl_catalog_category`='$catalogcat',`tbl_product_idtbl_product`='$product',`tbl_user_idtbl_user`='$userID',`imgpath`='$productimagepath', `updatedatetime`='$updatedatetime' WHERE `idtbl_catalog`='$recordID'";
    }else{
        $query = "UPDATE `tbl_catalog` SET `uom`='$uom',`group_type`='$type',`tbl_catalog_category_idtbl_catalog_category`='$catalogcat',`tbl_product_idtbl_product`='$product',`tbl_user_idtbl_user`='$userID', `updatedatetime`='$updatedatetime' WHERE `idtbl_catalog`='$recordID'";
    }
    
    if($conn->query($query)==true){
       
        header("Location:../productcatalog.php?action=6");
    }
    else{header("Location:../productcatalog.php?action=5");}
}
?>