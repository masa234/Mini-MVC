<?php

class Application {
    protected $request;
    protected $session;
    protected $login_method = array( '/login' ,'/sessions/create' );
    protected $register_method = array( '/users/new', '/users/create' );
    protected $login_param = array( 'controller' => 'SessionController', 'action' => 'new' ); 
    protected $home_param  = array( 'controller' => 'HomeController', 'action' => 'index' );

    public function __construct() 
    {
        $this->initialize();
    }

    public function initialize() 
    {
        $this->request = new Request;
        $this->session = new Session;
    }
    
    public function run() 
    {
        $path_info = $this->request->get_pathinfo();
        $params = $this->request->get_info( $path_info );

        if ( ! $params ) {
            $this->NotFound404( 'Page not Found' );
        }
        
        $controller_class = ucfirst( $params['controller'] ) . 'Controller';
        $controller_instance = $this->get_Controller( $controller_class );

        if ( ! $controller_instance ) {
            $this->NotFound404( $controller_class . ' Not Found' );
        }

        $action = $params['action'];

        if ( ! in_array( $path_info, $this->login_method ) // 未ログイン状態でログインが必要なページにアクセスしたとき。
            && ! in_array( $path_info, $this->register_method )
            && ! $this->session->is_Authenticated() ) {
            $controller_instance = $this->get_Controller( $this->login_param['controller'] );   
            $this->session->flash( 'ログインしてください', 'danger' ); 
            $this->run_Method( $controller_instance, $this->login_param['action'] );
        } else if ( $this->session->is_Authenticated()   // ログイン状態で登録、ログイン関連のページにアクセスしたとき。(多重ログイン防止)
                    && ( in_array( $path_info, $this->login_method )
                    || in_array( $path_info, $this->register_method ) ) ) {  
                    $controller_instance = $this->get_Controller( $this->home_param['controller'] );   
                    $this->session->flash( 'ログイン状態でこのページを閲覧することはできません', 'danger' ); 
                    $this->run_Method( $controller_instance, $this->home_param['action'] );
        }

        $this->run_Method( $controller_instance, $action );
    }

    public function run_Method( $controller_instance, $action ) 
    {   
        if ( ! method_exists( $controller_instance, $action ) ) {
            $this->NotFound404( $action . ' Not Found' );
        } 

        $controller_instance->$action();
    }

    public function get_Controller( $controller_class )
    {
        $controller_file = 'controllers/' . $controller_class . '.php';

        if ( is_readable( $controller_file ) ) {
            require_once $controller_file;

            if ( ! class_exists( $controller_class ) ) {
                return false;
            }
            return new $controller_class; 
        }

        return false;
    }

    public function NotFound404( $str ) 
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
    min-width: 600px;   /*中央配置するボックスの横幅*/
    min-height: 400px;  /*中央配置するボックスの縦幅*/
}

.center{
    margin: -200px 0 0 -300px;  /*縦横半分をネガティブマージンでずらす*/
    position: absolute;     /*body要素に対して絶対配置*/
    top: 50%;       /*上端を中央に*/
    left: 50%;      /*左端を中央に*/
    width: 600px;   /*横幅*/
    height: 400px;  /*縦幅*/
}

.container{
    text-align: center;
    vertical-align: middle;
}
</style>

</head>
<body>

<div class="jumbotron center">
    <h1>404 Not Found</h1>
    <p class="lead">お探しのページが見つかりませんでした。</p>
    <h2><?= htmlspecialchars( $e->getMessage(), ENT_QUOTES ) ?></h2>
    <a href="authenticate" class="btn btn-primary">ログイン画面はこちら</a>
    <a href="events/new" class="btn btn-info">ログインしている場合はこちら</a>
</div>

</body>
</html> 


<?php exit();}
} }?>