<?php

return [
    ['GET', '/', 'main_index'], // main page
    ['GET', '/register', 'register_index'], // view register form
    ['POST', '/register', 'register_register'], // register user
    ['GET', '/login', 'login_register'], // view login form
    ['POST', '/login', 'login_login'], // login user
    ['POST', '/logout', 'login_logout'], // logout user
];
