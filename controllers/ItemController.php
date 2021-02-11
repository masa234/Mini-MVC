<?php

class ItemController extends Controller
{
    public function index() 
    {      
        return $this->render(
            'items/items'    
        );
    }

    // 出品画面
    public function new() 
    {       
        return $this->render(
            'items/new'
        );
    }

    // 出品処理
    public function create() 
    {       
        if ( ! $this->request->is_Post() ) {
            $this->session->flash( 'Postメソッドでなければこのページにはアクセスできません。', 'danger' );
            $this->redirect( 'items/new' );
        }

        $inputs =
            array(
                'name'   => $this->request->get_Post( 'item_name' ),
                'price'  => $this->request->get_Post( 'item_price' ),
                'tags'    => $this->request->get_Post( 'item_tag' ),
                'detail' => $this->request->get_Post( 'item_detail' ),
                'user_id'=> $this->session->get_Current_id()
            );

        $this->Render_if_ValidFail( $inputs, 'items/new' );
        
        $inputs += array( 
                'img' => $this->session->get( 'work' )
            );

        $result = $this->model->create( 
                $inputs
            );

        if ( $result ) {
            $this->session->flash( '商品の出品に成功しました' );
            $this->redirect( 'items' );
        } else {
            $this->session->flash( '商品の出品に失敗しました' );
            $this->redirect( 'items/new' );
        }
        
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