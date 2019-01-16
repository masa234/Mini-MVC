<?php

class User extends Model {
    // @return array ( array( カラム名 => array( POSTされた値=>チェック項目 ) )の形式の連想配列を返却します)
    public function get_Rules()
    {
        return 
        array(
            array( 'user_name'
            =>
                array( 
                    'title'    => 'ユーザ名',
                    'required' => '',
                    'uniq'     => array( 'users' => 'user_name' ),
                    'max'      => 20 
                ) ),
            array( 'email'
            =>
                array( 
                    'title' => 'Email',
                    'required' => 'の形式として正しい値を入力してください(255文字以内)',
                    'max' => 255 
                ) ),
            array( 'password'
            =>
                array( 
                    'title' => 'パスワード',
                    'required' => '',
                    'regix' => array( '/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,15}+\z/i' 
                                => '半角英数字をそれぞれ1文字以上含む5～15文字以内の文字列'
                                )
                ) ),
            array( 'agreement'
            =>
                array( 
                    'title' => '利用規約',
                    'required' => 'に同意してください',
                    // 'in'       => array( 0, 1 )
                ) ),       
        );
    }
    
}