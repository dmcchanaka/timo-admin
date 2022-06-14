<?php

class dataFunctions {

    public static function CheckUser($uname, $pwd, $mycon) {
        $user_info = array();
        $u_name = mysqli_real_escape_string($mycon, $uname);
        $query = "SELECT 
            u.u_id,
            u.u_name,
            ut.user_type 
        FROM 
        users u 
            INNER JOIN 
        user_type ut ON u.u_tp_id = ut.u_tp_id 
        WHERE 
            u.status = '0' 
            AND u.username = '$u_name' 
            AND u.password = '" . md5($pwd) . "'";
        $result = mysqli_query($mycon, $query);
        $row = mysqli_fetch_assoc($result);

        $user_info['u_id'] = $row['u_id'];
        $user_info['u_name'] = $row['u_name'];
        $user_info['u_type'] = $row['user_type'];
        return $user_info;
    }

    public static function employees($mycon) {
        $query = "SELECT u_id, u_name, u_code FROM users u WHERE u.status = '0' AND u.u_tp_id = '2' ORDER BY u_name";
        $result = mysqli_query($mycon, $query);
        while($row = mysqli_fetch_assoc($result)){
            echo '<option value='.$row['u_id'].'>'.$row['u_name'].' - (' .$row['u_code']. ') '.'</option>';
        }
    }

    public static function getBaseUrl($filename) {
        // output: /myproject/index.php
        $currentPath = $_SERVER['PHP_SELF'];
    
        // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
        $pathInfo = pathinfo($currentPath);
    
        // output: localhost
        $hostName = $_SERVER['HTTP_HOST'];
    
        // output: http://
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
    
        // return: http://localhost/myproject/
        return $protocol . $hostName . "/timo-admin/" . $filename;
    }
}
