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
                'agreement' => $this->request->get_Post( 'agreement' )
            ); 
 
        $this->Render_if_ValidFail( $inputs, 'users/new' );
            
        $result = $this->model->create( 
            array( 
                'user_name' => $inputs['user_name'],
                'email'     => $inputs['email'],
                'password'  => $inputs['password'],
                'img'       => 'background.png',
            ) );

        if ( $result ) {
            $this->session->flash( 'ユーザを作成しました' );
            $this->redirect( 'login' );
        } else {
            $this->session->flash( 'ユーザの作成に失敗しました', 'danger' );
            $this->render(
                'users/new'
            );
        }
    }

    // POSTされた値によって処理を分岐いたします。
    public function update()
    {   
        if ( ! $this->request->is_Post() ) {
            $this->redirect_back( 'このページはPOSTメソッドでなくてはアクセスできません。' );
        }

        $user_id = $this->session->get_Current_id();

        $user_name = $this->request->get_Post( 'user_name' );
        $email     = $this->request->get_Post( 'email' );
        $password  = $this->request->get_Post( 'password' );
        $current_password  = $this->request->get_Post( 'current_password' );
        $password_confirmation  = $this->request->get_Post( 'password_confirmation' );
        $img = $this->request->get_Post( 'b64' );

        if ( ! empty( $user_name ) ) {
            $inputs = array( 'user_name' => $user_name );
            // *** ユーザ名を変更せずにUpdateするとエラーが発生する

            $redirect_url = 'users/name_edit';
            $render_url = 'users/name_edit';
            $message = 'ユーザ名の変更に成功しました。';
            $fail_message = 'ユーザ名の変更に失敗しました。';
        } else if ( ! empty( $email ) ) {
            $email = filter_var( $email, FILTER_VALIDATE_EMAIL );
            $inputs = array( 'email' => $email );

            $redirect_url = 'users/mail_edit';
            $render_url = 'users/mail_edit';
            $message = 'Emailの変更に成功しました。';
            $fail_message = 'Emailの変更に失敗しました。';
        } else if ( ! empty( $password ) 
            ||  ! empty( $current_password  ) 
            ||  ! empty( $password_confirmation ) ) {
            $redirect_url = 'users/pass_edit';
            $render_url = 'users/pass_edit';
            $current_user = $this->session->current_user();
                
            if ( ! mb_strlen( $password )  ) {
                $fail_message = 'パスワードを入力してください';
            } else if ( ! mb_strlen( $current_password  ) ) {
                $fail_message = '現在のパスワードを入力してください';
            } else if ( ! mb_strlen( $password_confirmation  ) ) {
                $fail_message = '確認用のパスワードを入力してください';
            } else if ( $password != $password_confirmation ) {
                $fail_message = '入力されたパスワードと確認用のパスワードが違います';
            } else if ( ! password_verify ( $password , $current_user['password'] ) ) {
                $fail_message = '入力されたパスワードが登録されたものと誤っています';
            }else {
                $inputs = array( 'password' => $password );
                
                $message = 'パスワードの変更に成功しました。';
                $fail_message = 'パスワードの変更に失敗しました。';
            }
        } else if ( $img == '' 
            || ! empty( $img )  ) {
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $fileData = base64_decode($img);
            $random = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16);
            //saving
            $fileName = $random . '.png';
            $file_path = './images/'.$fileName;
    
            file_put_contents($file_path, $fileData);
            
            if ( $img == '' ) {
                $this->session->flash( '画像ファイルではない。もしくは画像の変換を行っていません。', 'danger' );
                $this->redirect( 'users/pin_edit' );
            }   

            $inputs = array( 'img' => $fileName );
            $redirect_url = 'users/pin_edit';
            $render_url = 'users/pin_edit';
            $message = 'PINの変更に成功しました。';
            $fail_message = 'PINの変更に失敗しました。';
        } 
        
        if ( isset( $inputs ) 
            && is_array( $inputs ) ) {
            
            $this->Render_if_ValidFail( 
                $inputs, 
                $render_url
            );
        } else {

            if ( $fail_message ) {
                $errors[] = $fail_message;
                $this->render( 
                    $render_url,
                    array( 
                        'with_input_errors' => $errors
                    )
                );
            } else {
                // form を介さずにこのページにPOSTメソッドでアクセスした場合。
                $this->redirect( $redirect_url );
            }
        }

        $result = $this->model->update(
            $user_id,
            $inputs
        );

        if ( $result ) {    
            $this->session->flash( $message );
        } else {
            $this->session->flash( $fail_message, 'danger' );
        }

        $this->session->reset_Current_user();
        $this->redirect( $redirect_url );
    }

    public function name_edit()
    {   
        return $this->render( 
            'users/name_edit'
        );
    }

    public function mail_edit()
    {
        return $this->render( 
            'users/mail_edit'
        );
    }

    public function pass_edit()
    {
        return $this->render( 
            'users/pass_edit'
        );
    }

    public function pin_edit()
    {
        return $this->render(
            'users/pin_edit'
        );
    }

    // public function pin_update()
    // {
    //     if ( ! $this->request->is_Post() ) {
    //         $this->redirect_back( 'このページはPOSTメソッドでなくてはアクセスできません。' );
    //     }

    //     $img = $this->request->get_Post( 'b64' );
    //     $img = str_replace('data:image/png;base64,', '', $img);
    //     $img = str_replace(' ', '+', $img);
    //     $fileData = base64_decode($img);
    //     $random = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 16);
    //     //saving
    //     $fileName = $random . '.png';
    //     $file_path = './images/'.$fileName;

    //     file_put_contents($file_path, $fileData);

    //     if( ! file_exists( $file_path ) 
    //         || ! exif_imagetype( $file_path ) ){
    //         $this->session->flash( '画像ファイルではない。もしくは画像の変換を行っていません。', 'danger' );
    //         $this->redirect( 'users/pin_edit' );
    //     }

    //     $datas = array(
    //         'img' => $fileName,
    //     );
    //     $user_id = $_SESSION['id'];
    //     $result = $this->model->update( 
    //         $user_id,
    //         $datas );
    //     if ( $result  ) {   
    //         $this->session->flash( 'ユーザのPin画像を編集しました' );    
    //         $this->redirect( 'users/pin_edit' );
    //     } else {
    //         $this->session->flash( '失敗しました', 'danger' );
    //         $this->redirect( 'users/pin_edit' );
    //     }
    // }

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
