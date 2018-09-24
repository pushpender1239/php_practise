<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<script language="JavaScript" type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
     
         <form action="" method="post" id ="upoadForm" enctype="multipart/form-data">

    <label for=""> Upload Image File</label>
    <input type="file" name="userImage[]" id="img"  multiple>
    <input type="text" name="imgname" id="name_img">
    <input type="button" value ="Save Image" id="save">
    <div id="targetLayer"></div>
    </form>

</body>



<script>
$("#save").on('click',(function(){

var formData = new FormData(this);
var file = [];
var file_count = document.getElementById('img').files.length;
    
//var file = document.getElementById('profile-img').files[0]; in case of single image
    
// ===============when there is multiple field in form data with file=================we use this

for(let i=0;i<file_count;i++)
{
    
  file[i] = document.getElementById('img').files[i];
  formData.append('SelectedFile'+[i], file[i]);

}       
    
      
      // formData.append('SelectedFile', file[2]);
      // formData.append('SelectedFile', file[3]);
      // formData.append('SelectedFile', file[4]);

       formData.append("name",$('#name_img').val());


//         FormData.append("key",value);
 //        formData.append("vehicleId",$('#vehicle').val());
 //        formData.append("capacity",$('#capacity').val());
 //        formData.append("price1",$('#price1').val());
 //        formData.append("km1",$('#km1').val());
 //        formData.append("price2",$('#price2').val());
 //        formData.append("loading",$('#loading').val());
 //        formData.append("unloading",$('#unloading').val());
 //        formData.append("distance",$('#distance').val());
 //        formData.append("minute",$('#minute').val());
 //        formData.append("overtime",$('#overtime').val());

        $.ajax({        
                    url: '<?php echo site_url();?>/Upload',
                    type: "POST",
                    data:  formData,                
                    // cache: false,
//======= contentType and processData are necessary for form data
                    contentType: false,
                    processData:false,
                    success: function(data)
                    {
                        alert('Success');
                    },
                    error: function(err)
                    { 
                        alert("data failure",err);
                    } 	        
               });
}));

//alert(formData);


</script>
</html>