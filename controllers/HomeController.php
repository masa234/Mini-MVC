<?php 

class HomeController extends Controller 
{
    public function index()
    {
        $user = $this->session->current_user();
        $item_model = new Item;
        $items_r = $item_model->all();    

        $user_model = new User;
        $items = array();

        foreach ( $items_r as $item ) {
            $user = $user_model->find( $item['user_id'] ); 
            $items += array( $item + array( 'user_name' => $user['user_name'] ) );   
        }
        
        return $this->render(
            'users/show',
            array( 
                'user' => $user,
                'items' => $items,
                 )
        );
    }
}