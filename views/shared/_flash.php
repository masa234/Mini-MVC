<?php

$flashes = $this->session->get( 'flash' );

if ( is_array( $flashes ) ) {
    foreach( $flashes as $type => $message ) {
        ?>
        <span class="error-area container">
        <div class="alert alert-dismissible alert-<?= $this->h( $type ) ?>">
        <?php
            print $this->h( $message ) . "。";
        ?><br><?php   
        ?>
        </div>  
        </span><?php
    }
}

$this->session->remove( 'flash' );