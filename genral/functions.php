<?php

function testMessage($condation, $message){

    $returnMessage = "";

    if ($condation) { 

        $returnMessage = "$message True";
    } else {

        $returnMessage = "$message False";
    };

    return $returnMessage;
};


function go($path){
    echo "<script>
    window.location.replace('/Login/$path');
    </script>";
};



