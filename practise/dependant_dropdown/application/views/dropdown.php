<!DOCTYPE html>
<html>
<head>
	<title>Dropdown</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style type="text/css">
		.margin{
			margin-bottom: 5px;
		}
		.size{
			width:200px;
			height: 20px;
		}
	</style>
</head>

<body onload="">

<div class="margin">
	
	<select id="country" class="size">
		<option>Country</option>
		<?php foreach($res as $r): ?>
			<option value="<?= $r['id'] ?>"> <?= $r['name'] ?></option>
		<?php endforeach; ?>
	</select>
</div>
<div class="margin">
	
	<select id="state" class="size">
		<option>State</option>
	</select>
</div>
<div class="margin">
	
	<select id="city" class="size">
		<option>City</option>
	</select>
</div>

<script type="text/javascript">


	$("#country").change(function(){
	var val =$(this).val();		

		$.ajax({
			url:'<?php echo site_url();?>/Dropdown/state',
			data:{id:val},
			type:'post',
			success:function(data)
			{
					$('#state').append(data);
				
			},
			error:function(err){
				alert("error"+err);
			}
		});
			
	});

	$("#state").change(function(){
		var val =$(this).val();	
		alert(val);
		$.ajax({
			url:'<?php echo site_url(); ?>/Dropdown/city',
			data:{id:val},
			type:'post',
			success:function(data)
			{
				$('#city').append(data);
			},
			error:function(err){
				alert("error"+err);
			}
		});
			
	});

</script>
</body>
</html>