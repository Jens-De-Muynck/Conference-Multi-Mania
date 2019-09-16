<?php
    // TinyUrl zodat alle image urls in de database passen
    function get_tiny_url($url)  {  
        $ch = curl_init();  
        $timeout = 5;  
        curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
        $data = curl_exec($ch);  
        curl_close($ch);  
        return $data;  
    }

    // Meerdere variables in URL
    function custom_url($letter, $page){
        $query = $_GET;
        $query[$letter] = $page;
        $query_result = http_build_query($query); 
        return $query_result;
    }
?>