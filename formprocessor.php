<?php

$orig = file_get_contents('php://input');
$data = json_decode($orig, JSON_UNESCAPED_UNICODE);
echo '原始資料: '. $orig.PHP_EOL;
var_dump($data);
