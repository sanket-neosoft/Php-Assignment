<?php
$num1 = array_rand(range(0, 9));
$num2 = array_rand(range(9, 1));
$pattern = $num1 . "+" . $num2 . "= ?";
$capsum = $num1 + $num2;
?>