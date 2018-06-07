<?php

//mysql:
//$db = mysqli_connect ("localhost","wi_knot_application","000000","wi_knot");
    

//pg:
$db = pg_connect (getenv("DATABASE_URL"));

    
?>
