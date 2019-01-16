<?php 

abstract class Model {
    protected $db;
    protected $session;
    protected $request;
    protected $default_order;

    public function __construct() {
        $this->db = $this->connect();
        $this->session = new Session;
        $this->request = new Request;
        if ( ! $this->default_order ) {
            $this->default_order = "";
        }
    }

    public function __destruct() {
        $this->db->close();
    }

    public function connect() {
        $HOST = "localhost";
        $USERNAME = "root";
        $PASSWORD = "";
        $DBNAME = "zemi3";
        
        $db = new mysqli( $HOST, $USERNAME, $PASSWORD, $DBNAME );
    
        if ( $db->connect_error ){
            print $db->connect_error();
            exit;
        } else {
            $db->set_charset( "utf8" );
        }
    
        return $db;
    }

    public function execute( $query ) {
        $result = $this->db->query( $query );

        return $result;
    }
    
    // val: query select文のみ
    public function fetch( $query ) {
        $result = $this->execute( $query );

        if ( ! is_bool( $result ) ) {
            $response = array();

            while ( $row = $result->fetch_assoc() ) {
                foreach( $row as $key => $value ) {
                    $response[$key] = $row[$key];
                }
                return $response;
            }
        } 

        return false;
    }

    public function fetchAll( $query ) {
        $result = $this->execute( $query );

            $response = array();

            while ( $row = $result->fetch_assoc() ) {
                $response[] = $row;
            }

            return $response;
        
    }

    public function escape( $str ) {
        return $this->db->real_escape_string( $str );
    }

    public function get_tableName() {
        $table_name = mb_strtolower( get_class( $this ) ) . "s";

        return $table_name;
    }


    // ここからCRUDメソッド定義

    public function all() {
        $table = $this->get_tableName();

        $query = "SELECT * FROM $table
                    $this->default_order
                ";
            
        $result = $this->fetchAll( $query );

        return $result;
    }

    public function create( $inputs ) 
    {   
        $table = $this->get_tableName();

        $culumns = "";
        $values = "";

        foreach( $inputs as $column_name => $value ) {
            if ( $column_name == 'password' ) {
                $value = $this->hash_password( $value );
            }   
            $culumns .= "`$column_name`, ";
            $values .= "'$value' , "; 
        }

        date_default_timezone_set( 'Asia/Tokyo' );
        $current_time = date( 'Y-m-d H:i' );
        $culumns .= "`created_at`";
        $values .= "'$current_time'";
        $query = 'INSERT INTO ' . $table . '(' . $culumns . ') VALUES (' . $values . ')';

        return $this->execute( $query );
    }

    // @ param $id int (更新するレコードのid)
    // @ param $inputs array (データベースのカラム=> 更新する値の形式の連想配列)
    // @ return bool
    public function update( $id, $inputs ) 
    {   
        $table = $this->get_tableName();
        $query = "UPDATE `$table` SET ";

        foreach( $inputs as $column_name => $value ) {
            $value = $this->escape( $value );

            if ( $column_name == 'password' ) {
                $value = $this->hash_password( $value );
            }   
            $query .= "`$column_name`= '$value' ,"; 
        }
        
        date_default_timezone_set( 'Asia/Tokyo' );
        $current_time = date( 'Y-m-d H:i' );
        $query .= "`updated_at`= '$current_time'"; 
        $id = $this->escape( $id );
        $query .= " WHERE `id` = '$id'";

        return $this->execute( $query );
    }

    public function hash_password( $password ) 
    {
        return password_hash( $password , PASSWORD_DEFAULT );
    }

    // @param $id(int) :削除するイベントのid
    // @return bool    :SQLのDELETE文の実行結果(trueまたはfalse)
    public function delete( $id ) 
    {
        $table = $this->get_tableName();
        $id = $this->escape( $id );

        $query = "DELETE FROM $table
                WHERE id = $id
                ";

        return $this->execute( $query );     
    }

    public function find( $id ) {
        $table = $this->get_tableName();
        $id = $this->escape( $id );

        $query = "SELECT * FROM $table
                WHERE id = $id
                ";

        $result = $this->fetch( $query );

        return $result;
    }

    public function find_by( $column, $value ) {
        $table = $this->get_tableName();
        $value = $this->escape( $value );

        $query = "SELECT * FROM $table
                WHERE $column = '$value'
                ";
            
        $result = $this->fetch( $query );

        return $result;
    }

    public function findOr404( $id ) {
        $result = $this->find( $id );

        if ( ! $result ) {
            try {
                throw new HttpNotFound( 'Data Not Found' );
            } catch ( HttpNotFound $e ) {
                print $e->getMessage();
                exit();
            }
        }

        return $result;
    }

    public function where( $column, $operator, $value, $and =null ) {
        $table = $this->get_tableName();

        $query = "SELECT * FROM $table
                  WHERE  $column $operator '$value' $and
                  $this->default_order
                ";
            
        $result = $this->fetchAll( $query );

        return $result;
    }

    public function findAndMine( $id, $user_id_key = 'id' ) {
        $result = $this->findOr404( $id );

        if ( $result[$user_id_key] != $this->session->get_Current_id() ) {
            try {
                throw new HttpNotFound( 'このデータの閲覧権限がありません' );
            } catch ( HttpNotFound $e ) {
                print $e->getMessage();
                exit();
            }
        }

        return $result;
    }

    // ここから、判定系

    public function is_Mine( $id, $user_id_key = 'id' ) {
        $result = $this->find( $id );

        return $result 
            && $result[$user_id_key] == $this->session->get_Current_id();
    }

    public function is_Uniq( $column, $value )
    {   
        $result = $this->where( $column, '=', $value );

        return count( $result ) == '0';
    }

    // pagination

    public function pagenation( $datas, $per = 25 ) 
    {      
        if ( $this->request->get_Get( 'page' ) ) {
            $page = $this->request->get_Get( 'page' );
        } else {
            $page = 1;
        }   

        $max_page = ceil ( count( $datas ) / $per );
        $start_point = ( $page * $per ) - ( $per + 1 ); // 1ページ目でperが25の場合0になる。 

        if ( count( $datas ) > 0 ) {
            for ( $i = 1; $i <= $per && $start_point + $i <= count( $datas ) -1; $i++ ) {
                $response[] = $datas[$start_point + $i];
            }
        } else {
            $response = array();
        }

        $return = array( $response, $max_page );

        return list( $response, $max_page ) = $return;
    }
}