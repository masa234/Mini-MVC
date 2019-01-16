<?php

class ItemController extends Controller
{
    public function index() 
    {      
            $_SESSION = array();
        return $this->render(
            'items/new'    
        );
    }

    // 出品 
    public function new() 
    {   

    }

    public function show() 
    {

    }

    public function edit() 
    {

    }

    public function update() 
    {

    } 

    public function delete() 
    {

    }
}