<?php

class Auto_Loader {
    protected $dirs;

    public function autoLoad() {
        spl_autoload_register( array( $this, 'my_autoload' ) );
    }

    public function set_dir( $dir ) {
        $this->dirs[] = $dir;
    }

    public function my_autoLoad( $class ) {
        foreach( $this->dirs as $dir ) {
            $filename = $dir . '/' . $class . '.php';
            if (is_readable( $filename ) ) {
                require $filename;
                break;
            }
        }
    }
}