<?php

return [
    ['GET', '/', 'main_index'], // main page
    ['GET', '/register', 'register_index'], // view register form
    ['POST', '/register', 'register_register'], // register user
    ['GET', '/login', 'login_index'], // view login form
    ['POST', '/login', 'login_login'], // login user
    ['GET', '/logout', 'login_logout'], // logout user
    ['GET', '/project/create', 'project_index'], // create project form
    ['POST', '/project/create', 'project_create'], // create project
    // AJAX
    ['POST', '/ajax/delete-project', 'project_delete'], // delete project
    ['POST', '/ajax/update-project', 'project_update'], // update project
    ['POST', '/ajax/create-task', 'task_create'], // create task
    ['POST', '/ajax/delete-task', 'task_delete'], // delete task
    ['POST', '/ajax/sort-task', 'task_sort'], // sort task
    ['POST', '/ajax/update-task', 'task_update'], // sort task
    ['POST', '/ajax/changePriority-task', 'task_changePriority'], // Change task priority
    ['POST', '/ajax/changeDeadline-task', 'task_changeDeadline'], // Change task priority
    ['POST', '/ajax/changeDone-task', 'task_changeDone'], // Change task priority
];
