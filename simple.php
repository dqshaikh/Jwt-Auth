<?php
//$env = include('./.env');
$env_vars = getenv();
print_r($env_vars);
$database = getenv('DB');
die;
$database = getenv('DB');
$host = getenv('DB_HOST');


$db = new PDO('mysql:host=localhost;dbname=symfonydb','root','Phpmyadmin@1');
require('vendor/autoload.php');

$faker = Faker\Factory::create();
$value = '["ROLE_USER"]';

foreach(range(1,100) as $x){
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
    $password = substr( str_shuffle( $chars ), 0, 8 );
    $db->query("INSERT INTO user (name,email,password,roles) VALUES ('$faker->name','$faker->email','$password','$value')");
 
}
