<!DOCTYPE html>
<html>
<head>
<?php include('nav.html');?>
<br><br><br>
<style>
table {
border-collapse: collapse;
width: 100%;
height: 530px;
margin-top: 25px;
font-family: 'Times New Roman', Times, serif;
font-size: 25px;
text-align: left;
}
th {
background-color: grey;
color: gold;
text-decoration: bold;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
<body>
<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Balance</th>.
</tr>
<?php
$conn = mysqli_connect("localhost", "root", "", "sparks");
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, name, email, balance FROM users";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"] . "</td><td>"
. $row["email"] . "</td><td>". $row["balance"] . "</td>";
}
echo "</table>";
} else { echo "0 results"; }
$conn->close();
?>
</table>
</body>
</html>