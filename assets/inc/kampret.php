<?php

$salt = '$1$emangkampret$';


$pass = 'syaripkampret';


$encrypted = crypt($pass, $salt);


print("salt: $salt | pass : $pass | encrypted : $encrypted \n<br />");


$matchtest = crypt($pass, $encrypted);

print("compare : $matchtest \n<br />");

print("match: " . ($matchtest == $encrypted?'true':'false'));
