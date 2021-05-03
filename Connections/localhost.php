<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_localhost = "127.0.0.1";
$database_localhost = "store";
$username_localhost = "ufo";
$password_localhost = "a78459032";
$localhost = @mysql_pconnect($hostname_localhost, $username_localhost, $password_localhost) or trigger_error(mysql_error(),E_USER_ERROR); 
?>