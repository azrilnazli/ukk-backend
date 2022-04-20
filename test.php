<?php 

$modules = ['user','video'];
$actions = ['list','create','edit','delete'];

// create permissions
foreach ($modules as $permission) 
{
    foreach($actions as $action)
    {
        $$permission[] = $action;
        //Permission::create(['name' => $permission.'-'.$action]);
    }
    
    //Permission::where(['name' => $permission])->delete();
}
var_dump($user);