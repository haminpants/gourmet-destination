<?php 
echo ("Profile not found<br>Redirecting to home page in 5 seconds...<br><a href=\"index.php\">Click here if not redirected</a>");
header("Refresh:5; URL=index.php");
return;
?>