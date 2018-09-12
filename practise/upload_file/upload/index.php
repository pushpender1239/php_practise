<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<script language="JavaScript" type="text/javascript" src="lib/jquery-3.3.1.js"></script>
<script>
$(document).ready(function (e){
  
$("#upoadForm").on('submit',(function(e){
  
e.preventDefault();//method stops the default action of an element from happening like form submit
var formData = new FormData(this);
console.log('getting');
$.ajax({
url: 'upload.php',//path of php file where we want to upload
type: "POST",
data:  formData,//to manipulate or add data  i.e "data": { "user_id": 451   }
contentType: false,//type of your content u r sending like application/json; charset=utf-8 
cache: false,
processData:false,//Preventing default data parse behavior......it assumes that data passed is an object.
success: function(data){
    console.log("success");
    console.log(data);
    // die("data".data);
 $("#targetLayer").html(data);
},
error: function(data){ 
    console.log("error");
    console.log(data);
    } 	        
});
}));

//$("#img").on("change", function() {
//        $("#upoadForm").submit();
//    });
});
    </script>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" id ="upoadForm">
        <label for=""> Upload Image File</label>
    <input type="file" name="userImage" id="img">
    <input type="submit" value ="Save Image" >
    <div id="targetLayer">heelo</div>
    </form>
</body>
</html>