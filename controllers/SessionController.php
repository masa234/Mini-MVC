<?php 

class SessionController extends Controller { 

    // ログイン
    public function new() 
    {
        return $this->render(
            'sessions/new'
        );
    }

    public function create()
    {   
        if ( ! $this->request->is_Post() ) {
            $this->redirect_back();
        }

        $inputs = 
            array(
                'user_name' => $this->request->get_Post( 'user_name' ),
                'password'  => $this->request->get_Post( 'password' ),
            );
            
        $model = new User;
        $user = $model->find_by( 'user_name', $inputs['user_name'] );

        if ( ! $user ) {
            $errors[] = 'ユーザ名が間違っています';
            $this->render(
                'sessions/new',
                array( 'with_input_errors' => $errors )
            );
        }

        if ( password_verify ( $inputs['password'], $user['password'] ) ) { 
            $this->session->flash( 'ログインに成功しました' );
            $this->session->add( 'user', $user );
            $this->redirect( 
                '/'
             );
        } else  {    
            $errors[] = 'パスワードが間違っています';
            $this->render(
                'sessions/new',
                array( 'with_input_errors' => $errors )
            );
        } 
    }

    public function signout()
    {   
        $this->session->clear();
        $this->session->flash( 'ログアウトしました' );
        $this->redirect( 'login' );
    }
}
