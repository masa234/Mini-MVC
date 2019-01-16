<?php

class Validate {
    protected $request;
    protected $session;

    public function __construct() 
    {
        $this->request = new Request;
        $this->session = new Session;
    }

    //  @return array
    public function get_Validresult( $inputs, $rules ) {
        $errors = array();

        foreach( $inputs as $input_name => $input_value ) {
            foreach( $rules as $rule_info ) {
                foreach( $rule_info as $column_name => $rule ) {
                    // カラムの値とinputされた値が等しい場合、処理をします。
                    if ( $input_name == $column_name ) {
                        foreach ( $rule as $condition => $value ) {
                            switch ( $condition ) {
                                case 'title':
                                    $title = $value;
                                    break;
                                case 'required':
                                    if ( ! mb_strlen( $input_value ) ) {
                                        if ( $value == '' ) {
                                            $errors[] =  $title . 'は空文字ではいけません';
                                        } else {
                                            $errors[] =  $title . $value;
                                        }
                                    }
                                    break;
                                case 'type':
                                    if( strpos( $value, 'file' ) !== false) {
                                        if ( $value == 'file(require)' ) {
                                            $error_string = $this->upload_Image( $input_value, $errors, true );
                                        } else {
                                            $error_string = $this->upload_Image( $input_value, $errors );
                                        }
                                        if ( $error_string ) {
                                            $errors[] = $error_string;
                                        }
                                        break;
                                    }
                                    if ( $value == 'numeric' 
                                        && ! is_numeric( $input_value ) ) {
                                        $errors[] =  $title . 'は' . '数値型でなくてはいけません';
                                        break;
                                    }
                                    if ( $value == 'bool' 
                                        && ! is_bool( $input_value ) ) {
                                        $errors[] =  $title . 'は' . 'trueまたはfalseでなくてはいけません';
                                        break;
                                    }
                                    if ( $value == 'date' ) {
                                        if ( ! $this->is_date( $input_value ) ) {
                                            $errors[] =  $title . 'は、時刻でなくてはいけません';
                                        } else if ( $this->is_Past( $input_value ) ) {
                                            $errors[] =  $title . 'は、現在時刻以降でなくてはいけません';
                                        }
                                    }
                                    break;
                                case 'max':
                                    if ( mb_strlen( $input_value ) > $value ) {
                                        $errors[] = $title . 'は' . $value . '文字以下でなくてはいけません';
                                    }
                                    break;
                                case 'min':
                                    if ( mb_strlen( $input_value ) < $value ) {
                                        $errors[] = $title . 'は' . $value . '文字以上で入力してください';
                                    }
                                    break;
                                case 'uniq':
                                    foreach( $value as $table => $column ) {
                                        $model_name = ucfirst( rtrim( $table, 's' ) );
                                        $model_instance = new $model_name;
                                        if ( ! $model_instance->is_Uniq( $column, $input_value ) ) {
                                            $errors[] = $title . 'が重複しています';
                                        } 
                                    }
                                    break;
                                case 'between':
                                    list( $min, $max ) = explode( '-', $value );
                                    if ( $min > $input_value
                                        || $max < $input_value ) {
                                            $errors[] =  $title . 'は' . $min . '文字から' . $max . '文字の範囲内で指定してください';
                                        }
                                    break;
                                case 'after_date':
                                    foreach( $value as $name => $val ) {
                                        if ( $input_value < $inputs[$val] ) {
                                            $errors[] = $title . 'は' . $name . '以降でなくてはいけません';
                                        }
                                    }
                                    break;
                                case 'in':
                                    $error = true;
                                    foreach( $value as $val ) {
                                        if ( $input_value == $val ) {
                                            $error = false;
                                        }
                                    }
                                    if ( $error ) {
                                        $errors[] = $title . 'は(' . implode( ",", $value ) . ")のうちのどれかでなくてはいけません";  ;
                                    }
                                    break;
                                case 'regix':
                                    foreach( $value as $regix => $format ) {
                                        if ( ! preg_match( $regix, $input_value ) ) {
                                            $errors[] = $title . 'は' . $format . 'でなくてはいけません';
                                        } 
                                    }
                                    break;
                            }
                        }
                    }
                } 
            }
        }
        
        return $errors;
    }

    // ***現在、数値以外の値を引数にしてこのメソッドを実行するとエラーが発生する状態です。
    // (DateTimeのコンストラクタが正常に呼び出せないので)
    // @param $date(string) : Datetime型かチェックする値。 
    // @return bool         : 引数がDateTime型なら、true そうでなければfalseを返却します。
    public function is_date( $date ) {
        $datetime = new DateTime( $date );
        $datetime = $datetime->format( 'Y-m-d\TH:i' );

        return $date == $datetime;
    }

    // 前提条件                 : $datetime はDateTime型であることが担保されていることとします。 
    // @param $datetime(date)  : 過去の日付かどうか、チェックしたい値
    // @return bool            : 引数が過去の日付なら、true そうでなければfalseを返却します。
    public function is_Past( $datetime ) {
        return $datetime < date( 'Y-m-d\TH:i' );
    }

    //  @params $input(string) : イメージアップロードのための、input type = file のname属性を指定します。
    //  @params $errors(array) : エラー情報を格納する配列を指定します。 
    //  @params $require( default:false )
                           //  : 画像が指定されていない場合にエラーを発生されたい場合は、true を指定してください。
    //  @return (string)       : エラーが発生した場合エラー文（string型）を返却します。
    public function upload_Image( $input ,$errors, $require = false ) 
    {      
        if ( isset( $_FILES[$input] ) 
            && is_uploaded_file( $_FILES[$input]["tmp_name"] ) ) {
            $files = $_FILES[$input];
            $extension = substr( mime_content_type( $files["tmp_name"] ) , 6 ); // ファイルの拡張子
            // list( $vertical, $holizontal ) = getimagesize( $files["tmp_name"] );
        
            try {
                // フォーム改ざん時、発生するエラーを探知
                if ( ! isset( $files['error'] ) 
                    || ! is_int( $files['error'] ) ) {
                    throw new Exception('パラメータが不正です');
                } switch ( $files['error'] ) {
                    case UPLOAD_ERR_OK: // OK
                        break;
                    case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                        throw new Exception('ファイルが選択されていません');
                    case UPLOAD_ERR_INI_SIZE:
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new Exception( 'ファイルサイズが大きすぎます' );
                    default:
                        throw new Exception( 'その他のエラーが発生しました' );
                }
        
                if ( ! $ext = array_search( 
                    $extension, 
                    array( 'gif', 'jpeg', 'png',
                     )
                )) {
                    throw new Exception( 'ファイルの形式エラーです' );
                }
                    
                $dir = 'images';
                $filename = date( 'YmdHis' ) . rand( 10, 150000 ) . '.' . $extension;
                
                if ( move_uploaded_file( $files["tmp_name"], $dir . '/' . $filename ) ) {
                    chmod( $dir . '/' . $filename , 0644 );
                    $this->session->add( 'work', $filename );
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            if ( $require != false ) {
                return '画像がアップロードされていません';
            }
        }
    }
}
