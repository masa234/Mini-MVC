<?php 

class Request {

    public function get_info() 
    {
        $routes = $this->get_routes();
        $path = $this->get_pathinfo();

        if ( $id_param = $this->get_id_param() ) {
            $path = substr( $path, 0, strcspn( $path, $id_param ) ); 
        }

        if ( $path != '/' ) {
            $path = rtrim( $path, '/' );
        }       

        foreach( $routes as $route => $params ) {
            if ( $route == $path ) {
                return $params;
            }
        }   
    }

    public function get_id_param() 
    {
        $routes = $this->get_routes();
        $path = $this->get_pathinfo();

        $tokens = explode( '/' , $path );
        foreach( $tokens as $token ) {
            if ( is_numeric( $token ) ) {
                return $id_param = $token;
            }
        }
    }

    // ルーティング定義
    // @return array
    public function get_routes() 
    {
        return array( 
            '/'
            => array( 'controller' => 'home', 'action' => 'index' ),
            '/login'
            => array( 'controller' => 'session', 'action' => 'new' ),
            '/sessions/create'
            => array( 'controller' => 'session', 'action' => 'create'  ),
            '/signout'
            => array( 'controller' => 'session', 'action' => 'signout'  ),
            '/users'
            => array( 'controller' => 'user', 'action' => 'index'  ),
            '/users/new'
            => array( 'controller' => 'user', 'action' => 'new'  ),
            '/users/create'
            => array( 'controller' => 'user', 'action' => 'create' ),
            '/items'
            => array( 'controller' => 'item', 'action' => 'index' ),
            '/items/create'
            => array( 'controller' => 'item', 'action' => 'create' )
        );
    }

    public function get_Request_url() 
    {
        return ( empty( $_SERVER["HTTPS"] ) ? "http://" : "https://" ) . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
    }

    public function get_AppPath() 
    {
        $scriptname = $_SERVER['SCRIPT_NAME'];
        $protocol = empty( $_SERVER['HTTPS'] ) ? 'http://' : 'https://' ;
        
        return $protocol .  $_SERVER['HTTP_HOST'] . dirname( $scriptname );
    }

    public function get_pathinfo() 
    {
        $app_url = $this->get_AppPath();
        $request_url = $this->get_Request_url();
        if( strcmp( $request_url, $app_url ) == 0 ){
            // アプリのURLと一致した場合
            return '/';
        } else {
            $request = substr( $request_url, mb_strlen( $app_url ) );
            $request = substr( $request, 0, strcspn( $request, '?' ) );
            return $request;
        }
    }

    // view内で表示する場合、エスケープする
    public function get_Get( $key ) 
    {
        $post_data  = ( string )filter_input( INPUT_GET, $key );
        
        return $post_data;
    }    

    // view内で表示する場合、エスケープする
    public function get_Post( $key ) 
    {
        $post_data  = ( string )filter_input( INPUT_POST, $key );
        
        return $post_data;
    }

    public function is_Post()
    {
        return $_SERVER ['REQUEST_METHOD'] === 'POST';
    }
}