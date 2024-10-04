<?php

$connections = mysqli_connect ("localhost:3307","root", "" , "seams_php");
if(mysqli_connect_errno()){

    echo "Failed to Connect to mysqli:". mysqli_connect_error();
    
}else{

    echo "";
}



