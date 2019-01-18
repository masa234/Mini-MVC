<?php

class ItemController extends Controller
{
    public function index() 
    {      
        return $this->render(
            'items/new'    
        );
    }

    // 出品 
    public function new() 
    {       
        return $this->render(
            'items/new'
        );
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