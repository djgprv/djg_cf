<?php
session_start();
$operators=array('-','*','+');
$first_num=rand(1,5);
$second_num=rand(6,11);
shuffle($operators);
$expression=$second_num.' '.$operators[0].' '.$first_num;
eval("\$session_var=".$second_num.$operators[0].$first_num.";");
$_SESSION['captcha_id'] = md5($session_var);
header('Cache-control: no-cache');
$image = imagecreatefrompng('button.png');
$colour = imagecolorallocate($image, 178, 178, 178);
$font = 'fonts/wolf.ttf';
$rotate = rand(-10, 10);
imagettftext($image, 20, $rotate, 20, 25, $colour, $font, $expression);
imagepng($image);
?>