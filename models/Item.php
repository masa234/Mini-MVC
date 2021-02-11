<?php

class Item extends Model {
    // @return array ( array( カラム名 => array( POSTされた値=>チェック項目 ) )の形式の連想配列を返却します)
    public function get_Rules()
    {
        return 
        array(
            array( 'name'
            =>
                array( 
                    'title'    => '商品名',
                    'required' => '',
                    'max'      => 50 
                ) ),
            array( 'price'
            =>
                array( 
                    'title' => '値段',
                    'required' => 'の形式として正しい値を入力してください(255文字以内)',
                    'type' => 'numeric',
                    'min' => 0 
                ) ),
            array( 'tags'
            =>
                array( 
                    'title' => 'タグ',
                    'max'      => 30
                ) ),
            array( 'detail'
            =>
                array( 
                    'title' => '説明文',
                    'required' => '',
                ) ),  
            array( 'img'
            =>
                array( 
                    'title' => '商品画像',
                    'required' => '',
                    'type'     => 'file(require)',
                ) ),     
        );
    }
    
}