<?php ob_start();

define( "FORMTITLE", "サインイン" ); 
define( "MESSAGE", "" ); 
define( "BUTTONTEXT", "サインイン" );
$post_path =  $this->app_path . '/users/create';
$link_url = $this->app_path . '/';
define( "OTHERBUTTONTEXT", "ログインはこちら" );
$user = null;

if ( ! isset( $with_input_errors ) ) {
    $with_input_errors = null;
}

?>

<?php $this->render( "/shared/_user_form",
    array(  
        'user'      => $user,
        'post_path' => $post_path,
        'with_input_errors' => $with_input_errors,
        'link_url'  => $link_url,
        'register_form' => true
    ) ); ?>

<?php $yield = ob_get_clean() ?>
<?php $this->render( 'template',
  array( 'yield' => $yield ) ) ?>

