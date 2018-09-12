<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
$q = intval($_GET['q']);
$conn = mysqli_connect('localhost','root','','tutorials');
if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}
mysqli_select_db($conn,"ajax_");
$sql="SELECT * FROM Demo WHERE id = '".$q."'";
$result = mysqli_query($conn,$sql);
echo "<table>
<tr>
<th>Location</th>
<th>longitude </th>
<th>latitude</th>

</tr>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['location'] . "</td>";
    echo "<td>" . $row['longitude'] . "</td>";
    echo "<td>" . $row['latitude'] . "</td>";
    
    echo "</tr>";
}
echo "</table>";
mysqli_close($conn);
?>
</body>
</html>