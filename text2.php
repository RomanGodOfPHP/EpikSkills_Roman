<?php
echo "dfbkfekj";
$arr = glob('Blogs/*.txt');
foreach($arr as $key=>$value){
    echo "Блог № $keyе".PHP_EOL;
    echo file_get_contents($value).PHP_EOL;
    echo "".PHP_EOL;
}