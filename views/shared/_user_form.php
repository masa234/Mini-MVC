  <?php if ( ! isset( $register_form ) ) {
      $register_form = false; 
  } ?>

      <div class="container">
		  <div class="box">
			  <div class="row">
				  <div class="col-md-6">
					  <div class="well">
						  <form id="loginForm" method="POST" action = "<?= $this->h( $post_path ) ?>" enctype="multipart/form-data" novalidate>
              <?php $this->render( '/shared/_flash' ) ?>
                <div class="text-center mb-4">
                  <h1 class="h3 mb-3 font-weight-normal"><?=$this->h( FORMTITLE ); ?></h1>
                  <p><?=$this->h( MESSAGE ); ?></p>
                </div>
                <?php if ( isset( $with_input_errors ) ): ?>
                  <?php $this->render( 'shared/_with_input_errors',
                  array( 'with_input_errors' => $with_input_errors ) ) ?>
                <?php endif; ?>

							  <div class="form-group">
                  <label for="inputUsername">ユーザ名</label>
                  <input type="text" id="inputUsername" class="form-control" name="user_name" placeholder="お名前を10文字以内で入力してください" 
                  value="<?=$this->h( $this->get_Value( 'user_name', $user ) ) ?>"
                  onKeyUp="countLength( value, 'username_length' );" required autofocus>
							  </div>

                <?php if ( $register_form ): ?>
                  <label for="inputEmail">Eメール</label>
                  <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Emailで入力してください"
                  value="<?=$this->h( $this->get_Value( 'email', $user ) ) ?>"required>
                <?php endif; ?>

							  <div class="form-group">
                  <label for="inputPassword">パスワード</label>
                  <input type="password" id="inputPassword" class="form-control" name="password" placeholder="Passwordを5~15文字以内で入力してください"
                  value="<?=$this->h( $this->get_Value( 'password', $user ) ) ?>"  required>
							  </div>

                <?php if ( $register_form ): ?>
                  <input type="file" name="user_img">
                <?php endif; ?>

                <button class="btn btn-lg btn-success btn-block" type="submit" name= "action" ><?=$this->h( BUTTONTEXT ); ?></button>
						  </form>
					  </div>
				  </div>
				  <div class="col-md-6">
					  <p class="lead">会員登録は <span class="text-success">無料</span>今すぐ登録！</p>
					  <ul class="list-unstyled">
						  <li><span class="fa fa-check text-success"></span> すべての注文が見れます。</li>
						  <li><span class="fa fa-check text-success"></span> 早い追加注文。</li>
						  <li><span class="fa fa-check text-success"></span> お気に入りを保存できます。</li>
						  <li><span class="fa fa-check text-success"></span> 素早い購入。</li>
						  <li><span class="fa fa-check text-success"></span> クーポンプレゼント <small>(カスタマー限定)</small></li>
						  <li><a href="/read-more/"><u>さらに詳しく</u></a></li>
					  </ul>
					  <p><a href="<?=$this->h( $link_url ); ?>" class="btn btn-info btn-block"><?=$this->h( OTHERBUTTONTEXT ); ?></a></p>
				  </div>
			  </div>
		  </div>
    </div><!-- /container -->
  