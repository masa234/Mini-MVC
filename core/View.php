<?php

class View {
    private $request;
    private $session;
    private $app_path;

    public function __construct() 
    {
        $this->request = new Request;
        $this->session = new Session;
        $this->app_path = $this->request->get_Apppath();
    }

    public function render( $url, $valiables = array() ) { 
        if ( count( $valiables ) > 0 ) {
            foreach( $valiables as $val_name => $value ) {
                ${$val_name} = $value;
            }
        }   

        $file = 'views/' . $url . '.php';
        require $file;
    }

    public function h( $str ) {
        return htmlspecialchars( $str, ENT_QUOTES, 'UTF-8');
    }

    public function get_Value( $key, $object, $default = "" ) {
        if ( $this->request->get_Post( $key ) ) {
            return $this->request->get_Post( $key );
        } else if ( $object 
            && isset( $object[$key] ) ){
            return $object[$key];
        }
        
        return $default;
    }

    public function get_date( $date ){
        $date = new DateTime( $date ); 

        return  $date->format('Y-m-d\TH:i');
    }
}