<?php

//global var for storing the gravatar image

function gravatar_url($email)
{
    $email = md5($email);
    return "https://gravatar.com/avatar/{$email}?s=60&d=http://www.gravatar.com/avatar/?d=identicon";
}
