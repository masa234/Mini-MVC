<?php

// $with_input_errorsが存在する場合、表示する
if ( ! is_null( $with_input_errors ) ) {
    ?>
    <span class="error-area container">
    <div class="alert alert-dismissible alert-warning">
    <?php
    if ( is_array( $with_input_errors ) 
        && count( $with_input_errors ) > 0 ) {
        foreach( $with_input_errors as $error ) {
            print '・' . $this->h( $error ) . "。";
            ?><br><?php 
        }    
    } else if ( ! empty( $with_input_errors ) ) {
        print '・' . $this->h( $with_input_errors ) . "。";
    }
    ?>
    </div>  
    </span><?php
}