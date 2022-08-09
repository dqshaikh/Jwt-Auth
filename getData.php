<?php

require('vendor/autoload.php');
$type = $_REQUEST['type'];
$faker = Faker\Factory::create();

$array = array();

if($type == 'users'){
$value = '["ROLE_USER"]';
foreach(range(1,1000) as $x){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
    $password = substr( str_shuffle( $chars ), 0, 8 );
    $array[] = array("name"=>$faker->name,"email"=>$faker->email,"password"=>$password);
}
} else {
    foreach(range(1,1000) as $x){
        $array[] = array("title"=>$faker->sentence($nbWords = 2, $variableNbWords = true),"body"=>$faker->text($maxNbChars = 200) ,"publish_date"=>$faker->date($format = 'Y-m-d', $max = 'now'));
    }
}
echo json_encode($array);
