$(function() {
    $('.btn').on( 'click', function() {
        $( '.btn' ).css('background-color', 'skyblue');
        $( '.btn' ).css('border', 'transparent 1px solid');
    });
});

function countLength( value, max_length, feed_back_field ) {  
    var count = $(value).val().length;
    if ( count > max_length ) {
        $( value ).removeClass("invalid");
        $( value ).addClass("is-invalid");
        $( feed_back_field ).css('color', '#E74C3C');
        $( feed_back_field ).text( max_length + '文字以内で入力してください' );
    }

    if ( count <= max_length  ) {
        $( value ).removeClass("is-invalid");
        $( value ).addClass("is-valid");
        $( feed_back_field ).css('color', '#18BC9C');
        $( feed_back_field ).text( '入力OKです' );
    }   
}

function check_email_format( value, max_length, feed_back_field ) {     
    if ( $(value).val().match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)  ) {
        $( value ).removeClass("is-invalid");
        $( value ).addClass("is-valid");
        $( feed_back_field ).css('color', '#18BC9C');
        $( feed_back_field ).text( '入力OKです' );
    } else {
        $( value ).removeClass("invalid");
        $( value ).addClass("is-invalid");
        $( feed_back_field ).css('color', '#E74C3C');
        $( feed_back_field ).text( 'メールアドレスの形式で指定してください' );
    }
}