<html>
<head>

</head>
<body>
<form>
<!-- <select name="users" onchange="show_user(this.value)">
  <option value="">Select a person:</option>
  <option value="1">Mark Dooley</option>
  <option value="2">Lewis Kirkbride</option>
  <option value="3">Jack Lee</option>
  <option value="4">Mary Jefferson</option>
  </select> -->
  <input type="text" name="id" id="id" onchange="show_user(this.value)">
  <script>
function show_user(str) {
    console.log(str);
    if (str == "") {
        document.getElementById("txt_hint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
// script for browser version above IE 7 and the other popular browsers (newer browsers)
            xmlhttp = new XMLHttpRequest();
        } 
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txt_hint").innerHTML = this.responseText;
// get the element in which we will use as a placeholder and space for table
            }
        };
        xmlhttp.open("GET","index2.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
 
</form>
<br>
<div id="txt_hint"><b>This is where info about the person is displayed.</b></div>
</body>
</html>