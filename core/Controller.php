<?php 

abstract class Controller {
    protected $session;
    protected $request;
    protected $model;

    public function __construct() 
    {
        $this->initialize();
        $model_name = substr( get_class( $this ), 0, -10 );
        if ( is_readable( 'models/' . $model_name . '.php' ) ) {
            $this->model = new $model_name;
        }
    }

    public function initialize() 
    {
        $this->session = new Session;
        $this->request = new Request;
    }

    public function redirect( $path )
    {
        $app_url = $this->request->get_AppPath();
        $redirect_url = $app_url . '/' . $path;
        
        header( "Location: $redirect_url ");
        exit();
    }

    public function redirect_back( $message = null ) 
    {   
        $redirect_url = $_SERVER['HTTP_REFERER'];
        
        if ( $message ) {
            $this->session->flash( $message, 'danger' );
        }

        if ( isset( $redirect_url ) ) {
            header( "Location: $redirect_url ");
            exit();
        } else if ( $this->session->is_Authenticated ){    
            $this->redirect( 'index' );
        } else {
            $this->redirect( 'sessions/new' );
        }
    }

    public function render( $url = null, $valiables = array() )
    {
        $view = new View();
        
        $view->render( $url, $valiables );
        exit();
    }

    // @param $checklist(array) : (POSTされた項目=>チェックされた項目の連想配列)
    // @param $path(string)     : Controllerのrenderメソッドに渡すpath
    // @param $datas(array)     : renderしたViewで使用する変数を格納した連想配列
    public function Render_if_ValidFail( $inputs, $path, $datas = array() )
    {    
        $validate = new Validate;
        $with_input_errors = $validate->get_Validresult( $inputs, $this->model->get_Rules() );
        
        if ( count( $with_input_errors ) > 0 ) {
            $datas += array( 'with_input_errors' => $with_input_errors );
            $this->render( 
                $path,
                $datas
                );
        }
    }

    public function NotFound404( $str = 'Page Not Found' ) 
    {
        try {
            throw new HttpNotFound( $str );
        } catch ( HttpNotFound $e ) {
       ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<style>
html,body{
    hight: 100%;    /*高さを100％に設定*/
}

body{
    margin: 0;
    padding: 0;
    positiion: relative;
    min-width: 600px;   /*中央配置するボックスの横幅*/
    min-height: 400px;  /*中央配置するボックスの縦幅*/
}

.center{
    margin: -200px 0 0 -300px;  /*縦横半分をネガティブマージンでずらす*/
    position: absolute;     /*body要素に対して絶対配置*/
    top: 50%;       /*上端を中央に*/
    left: 50%;      /*左端を中央に*/
    width: 600px;   /*横幅*/
    height: 400px;   /* 縦幅 */
}

</style>

</head>
<body>

<div class="jumbotron center">
    <h1>404 Not Found</h1>
    <p class="lead">お探しのページが見つかりませんでした。</p>
    <h2><?= htmlspecialchars( $e->getMessage(), ENT_QUOTES ) ?></h2>
    <a href="<?= htmlspecialchars( $this->request->get_AppPath(), ENT_QUOTES ) ?>/users/new" class="btn btn-primary">ログイン画面はこちら</a>
    <a href="<?= htmlspecialchars( $this->request->get_AppPath(), ENT_QUOTES ) ?>/events/new" class="btn btn-info">ログインしている場合はこちら</a>
</div>

</body>
</html> 


<?php exit();} 
} }?>
