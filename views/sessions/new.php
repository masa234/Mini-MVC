<?php ob_start();

define( "FORMTITLE", "ようこそ" ); 
define( "MESSAGE", "" ); 
define( "BUTTONTEXT", "ログイン" );
$post_path =  $this->app_path . '/sessions/create';
$link_url = $this->app_path . '/users/new';
define( "OTHERBUTTONTEXT", "サインインはこちら" );
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
        'link_url'  => $link_url
    ) ); ?>

<?php $yield = ob_get_clean() ?>
<?php $this->render( 'template',
  array( 'yield' => $yield ) ) ?>