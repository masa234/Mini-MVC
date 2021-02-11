<?php 

class Session 
{   
    // 静的なメンバ変数（後で調べてみる）
    protected static $session_started = false;

    public function __construct() 
    {
        if ( ! self::$session_started  ) {
            session_start();

            self::$session_started = true;
        }
    }

    public function add( $key, $value ) 
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key ) 
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function remove( $key ) 
    {
        unset( $_SESSION[$key] );
    }

    public function clear() 
    {
        $_SESSION = array();
    }

    public function is_Authenticated()
    {   
        $current_user = $this->current_user();

        return isset( $current_user );    
    }

    public function is_Admin() 
    {
        $current_user =  $this->current_user();

        return $this->is_Authenticated() 
            && $current_user['admin'];
    }

    public function flash( $message, $type = 'success' ) 
    {   
        $_SESSION['flash'][$type] = $message;
    }

    public function get_Current_id() 
    {   
        $user = $this->current_user();
        
        // ガード処理 （いらないかもしれません）
        if ( $user ) {
            return $user['id'];
        } else {
            return null;
        }
    }

    public function current_user() 
    {   
        return $this->get( 'user' );
    }

    public function reset_Current_user()
    {
        $user_id = $this->get_Current_id();
        $user_model = new User;

        $user = $user_model->find( $user_id );

        $this->add( 'user', $user );
    }
}