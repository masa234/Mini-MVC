<?php 

class UserController extends Controller { 
    protected $default_order = "ORDER BY created_at DESC";

    // アクセス条件： 管理者のみ
    public function index()
    {   
        if ( ! $this->session->is_Admin() ) {
            $this->session->flash( 'このページの閲覧権限がありません' );
            $this->redirect( 'event_list' );
        }

        $users = $this->model->all();

        return $this->render(
            'users/user_list',
            array( 'users' => $users )
        );
    }

    public function new()
    {   
        return $this->render(
            'users/new'
         );
    }

    public function create()    
    {       
        if ( ! $this->request->is_Post() ) {
            $this->redirect_back( 'このページはPOSTメソッドでなくてはアクセスできません。' );
        }

        $inputs = 
            array(
                'user_name' => $this->request->get_Post( 'user_name' ),
                'email'     => filter_var( $this->request->get_Post( 'email' ), FILTER_VALIDATE_EMAIL ),
                'password'  => $this->request->get_Post( 'password' ),
                'img'       => "user_img"
                ); 
 
        $this->Render_if_ValidFail( $inputs, 'users/new' );
            
        $result = $this->model->create( 
            array( 
                'user_name' => $inputs['user_name'],
                'email'     => $inputs['email'],
                'password'  => $inputs['password'],
                'img'       => $this->session->get( 'work' ),
            ) );

        if ( $result ) {
            $this->session->flash( 'ユーザを作成しました' );
            $this->redirect( '/' );
        } else {
            $this->session->flash( 'ユーザの作成に失敗しました', 'danger' );
            $this->render(
                'users/new'
            );
        }
    }

    // アクセス条件 ： POSTメソッド、ログインユーザが管理者
    // 削除条件    ： ログインユーザが管理者で、自分以外を削除しようとしたとき。
    public function delete()
    {       
        if ( ! $this->session->is_Admin() ) {
            $this->session->flash( 'このページの閲覧権限がありません' );
            $this->redirect( 'event_list' );
        }
        
        if ( ! $this->request->is_Post() ) {
            $this->session->flash( 'このページはPOSTメソッドでなくてはアクセスできません' );
            $this->redirect( 'users' );
        }

        $user_id = $this->request->get_id_param();

        if ( $user_id == $this->session->get_Current_id() ) {
            $this->session->flash( '自分自身を削除することはできません。' );
            $this->redirect( 'users' );
        }

        $result = $this->model->delete( $user_id );

        if ( $result ) {
            $this->session->flash( 'ユーザの削除に成功しました' );
        } else {
            $this->session->flash( 'ユーザの削除に失敗しました', 'danger' );
        }

        $this->redirect( 'users' );
     }   
}
