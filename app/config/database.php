<?php

if (strpos($_SERVER['SERVER_NAME'], 'herokuapp') !== false) {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $host = $url["host"];
    $user = $url["user"];
    $pass = $url["pass"];
    $db = substr($url["path"],1);
} else {
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $db = DB_NAME;
}

return mysqli_connect($host, $user, $pass, $db);