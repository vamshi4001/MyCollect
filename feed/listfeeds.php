<?php
$username="username";
$user="vamshi23_admin";
$password="admin123";
$database="vamshi23_mycollect";
mysql_connect(localhost,$user,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM feeds";
$result=mysql_query($query);

$num=mysql_numrows($result);

mysql_close();


echo "<center><table border=1 cellpadding=10 ><thead>Feedbacks from users</thead>";

$i=0;
while ($i < $num) {
echo "<tr>";

echo "<td>";echo mysql_result($result,$i,"sno")."." ;echo "</td>";
echo "<td>";echo mysql_result($result,$i,"name");echo "</td>";
echo "<td>";echo mysql_result($result,$i,"email");echo "</td>";
echo "<td>";echo mysql_result($result,$i,"comment");echo "</td>";

echo "</tr>";
$i++;
}

echo "</table></center>";
?>