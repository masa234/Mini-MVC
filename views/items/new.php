<?php ob_start();

define( "FORMTITLE", "出品する" ); 
define( "MESSAGE", "" ); 
define( "BUTTONTEXT", "出品" );
$post_path =  $this->app_path . '/items/create';
$link_url = $this->app_path . '/';
define( "OTHERBUTTONTEXT", "出品されているリストはこちら" );
$item = null;

if ( ! isset( $with_input_errors ) ) {
    $with_input_errors = null;
}

?>

<?php $this->render( "/shared/_item_form",
    array(  
        'post_path' => $post_path,
        'with_input_errors' => $with_input_errors,
        'link_url'  => $link_url,
        'item'      => $item,
        'register_form' => true
    ) ); ?>

<?php $yield = ob_get_clean() ?>
<?php $this->render( 'template',
  array( 'yield' => $yield ) ) ?>