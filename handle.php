<?php

    //Web page need to be directed
    $npg = "success.html";

    //Create file variables
    $stuInfo = "stuInfo.txt";
    $log = "log.txt";
    
    
    //Retrieve variables from the submit login page
    $username = $_POST['username'];
    $password = $_POST['password'];
    $curTime = date('Y-m-d H:i:s');
    


    //Check if file exists
    if(!file_exists($stuInfo)){
        fopen($stuInfo, "wb");
        echo("File does not exist!");
    }
    
    if(!file_exists($log)){
        fopen($log,"wb");
        echo("File does not exist!");
    }
    
    //Validate student information
    $handle = fopen($stuInfo, "r");
    if($handle){
        while($line = fgets($handle)){
            
            $stID = substr($line, 0, strpos($line, "&"));
            $stPas = substr($line, strpos($line , '&') + 1, strlen($line));
            
            //Validate the student user
            
            $t1 = strcmp($stID, $username);
            $t2 = strcmp($password, $stPas);
        
            
            if($t1 == 0 && $t2 == 0){
                header("location: success.html");
                exit();
            }
        }
        
        fclose($handle);
        
        writeLog($username, $password, $curTime, "false", "log.txt");
        
        header("Location: error.html");
    }
    else{
        echo "Error opening the file";
    }
    
    
    function writeLog($username, $password, $curTime, $stat, $log){
        
        if(strcmp($stat, "true")==0){
            $logMsg = "Username: " . $username . " with password: " . $password . " successfully logged in at " . $curTime;
        }
        else{
            $logMsg = "Username: " . $username . " with password: " . $password . " had tried to login at " . $curTime;
        }
        
        $a = fopen($log, 'a');
        fwrite($a, $logMsg);
        fclose($a);
    }
    