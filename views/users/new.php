<?php
ob_start();

define( "FORMTITLE", "" ); 
define( "MESSAGE", "" ); 
define( "LINKTEXT", "" );
$post_path = $this->app_path . '/users/create';
$link_url = $this->app_path . '/login';
$form_name = "register";

if ( ! isset( $with_input_errors ) ) {
    $with_input_errors = null;
}

$user = null;
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">ユーザ登録</h1>
</div>

<p class="lead">ユーザを登録します</p>


<?php

$this->render( "/shared/_user_form",
    array(  
        'user'              => $user,
        'with_input_errors' => $with_input_errors,
        'post_path'         => $post_path,
        'form_name'     => $form_name,
        'link_url'          => $link_url,
        'button_text'       => 'ユーザを追加する'
      ) ); 
    ?>




    <style>
    .tag {
      background-color: #f5f5f5;
      color:#9b9b9b;
      border-radius:0.25rem;
    }
    .tag_name {
      margin: 0 0.25rem !important;
    }
    .card {
      display: flex; padding:0 !important;
      border-radius: 1rem !important;
      box-shadow: 0 2px 2px 0 rgba(0,0,0,0.14),0 3px 1px -2px rgba(0,0,0,0.12),0 1px 5px 0 rgba(0,0,0,0.2);
    }
    .card:hover {
      -webkit-transform: scale(1.01);
      -moz-transform: scale(1.01);
      -o-transform: scale(1.01);
      -ms-transform: scale(1.01);
      transform: scale(1.01);
    }

    .form-signin {
      width: 100%;
      max-width: 500px;
    }
    </style>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>


<?php $yield = ob_get_clean() ?>
<?php $this->render( 'template',
  array( 'yield' => $yield ) ) ?>