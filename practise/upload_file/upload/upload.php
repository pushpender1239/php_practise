<?php
//echo $_FILES["userImage"]["name"];
//echo $_FILES["userImage"]["type"];
//die();
$target_dir = "../upload/";
$target_file = $target_dir . basename($_FILES["userImage"]["name"]);
if (move_uploaded_file($_FILES["userImage"]["tmp_name"], $target_file)) 
{
    echo "getting data";
}
else
{
    echo "waiting for data";   
}
?>