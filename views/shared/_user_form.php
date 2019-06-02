  <form class="needs-validation form-signin" method="POST" action = "<?= $this->h( $post_path ) ?>" enctype="multipart/form-data" >
    <?php $this->render( '/shared/_flash' ) ?>
    <div class="text-center mb-4">
      <h1 class="h3 mb-3 font-weight-normal"><?=$this->h( FORMTITLE ); ?></h1>
      <p><?=$this->h( MESSAGE ); ?></p>
    </div>
    <?php if ( isset( $with_input_errors ) ): ?>
      <?php $this->render( 'shared/_with_input_errors',
      array( 'with_input_errors' => $with_input_errors ) ) ?>
    <?php endif; ?>

	<label for="inputUsername">ユーザ名</label>
	<span class="required">*</span>
	<input type="text" id="inputUsername" class="form-control form-control-lg" name="user_name" placeholder="お名前を10文字以内で入力してください" 
	value="<?=$this->h( $this->get_Value( 'user_name', $user ) ) ?>"
	onKeyUp="countLength( inputUsername, 15, user_name_feedback )"; required autofocus>
  <div id="user_name_feedback"></div>

	<?php if ( $form_name == "register" ): ?>
		<label for="inputEmail">Eメール</label>
		<span class="required">*</span>
		<input type="email" id="inputEmail" class="form-control form-control-lg" name="email" placeholder="Emailを入力してください"
		value="<?=$this->h( $this->get_Value( 'email', $user ) ) ?>"
    onKeyUp="check_email_format( inputEmail, 255, user_email_feedback )"; required> 
    <div id="user_email_feedback"></div>
  <?php endif ?>

	<label for="inputPassword">パスワード</label>
	<span class="required">*</span>
    <input type="password" id="inputPassword" class="form-control form-control-lg" name="password" placeholder="Passwordを5~15文字以内で入力してください"
    value="<?=$this->h( $this->get_Value( 'password', $user ) ) ?>"  required>

	<?php if ( $form_name == "register" ): ?>
		<label for="inputPassword">パスワード確認用</label>
		<span class="required">*</span>
		<input type="password" id="inputPassword" class="form-control form-control-lg" name="new_password" placeholder="Passwordを5~15文字以内で入力してください"
		value="<?=$this->h( $this->get_Value( 'password', $user ) ) ?>"  required>
		  
		<div class="mb-3">
			<div class="form-group">
				<label for="img">プロフィール画像</label>
				<div id="img" class="input-group">
				<div class="custom-file">
					<input type="file" id="img" class="custom-file-input" lang="ja" name="user_img" accept="image/*" />
					<label class="custom-file-label" for="user_img">ファイルを選択してください...</label>
				</div>
				<div class="input-group-append">
					<button type="button" class="btn btn-outline-secondary reset">取消</button>
				</div>
				</div>
			</div>
		</div>

		<div class="checkbox   mb-3">
			<label>
				<input type="checkbox" name="agreement" 
				<?php if ( ( $this->get_Value( 'agreement', $user ) ) ): ?>
				checked="checked"
				<?php endif; ?>
				> 利用規約に同意する
			</label>
			<span class="required">*</span>
		</div>
	<?php endif ?>

	<button class="btn btn-lg btn-success btn-block btn-signin" id = "button" type="submit" name= "action" ><?=$this->h( $button_text ); ?></button>
	
    <div class="hint-text"><a href="<?=$this->h( $link_url ); ?>"><?=$this->h( LINKTEXT ); ?></a></div>
    
    <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
  </form>

  <style>
    .form-signin input {
      margin-bottom: 0.5rem;
    }

    .form-signin input[type="email"] {
      margin-bottom: 0.5rem;
	} 
	
    .custom-file-input:lang(ja) ~ .custom-file-label::after {
      content: "参照";
    }
    .custom-file {
      max-width: 20rem;
      overflow: hidden;
    }
    .custom-file-label {
      white-space: nowrap;
    }
  </style>

      <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Icons -->
	<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
	<script src="<?= $this->h ( $this->app_path ) ?>/js/effect.js"></script>
    
    <script>
      feather.replace()

      $('.custom-file-input').on('change', handleFileSelect);

      function handleFileSelect(evt) {
        var target = $(this);
        $(target).parent().parent().parent().children('#preview').remove();// 繰り返し実行時の処理
        $(target).parent().parent().parent().children('.input-group').after('<div id="preview"></div>');
        var files = evt.target.files;

        for (var i = 0, f; f = files[i]; i++) {

          var reader = new FileReader();

          reader.onload = (function(theFile) {
            return function(e) {
              if (theFile.type.match('image.*')) {
                var $html = ['<div class="d-inline-block mr-1 mt-1"><img class="img-thumbnail" src="', e.target.result,'" title="', escape(theFile.name), '" style="height:100px;" /><div class="small text-muted text-center">', escape(theFile.name),'</div></div>'].join('');// 画像では画像のプレビューとファイル名の表示
              } else {
                var $html = ['<div class="d-inline-block mr-1"><span class="small">', escape(theFile.name),'</span></div>'].join('');//画像以外はファイル名のみの表示
              }

              $(target).parent().parent().parent().children('#preview').append($html);
            };
          })(f);

          reader.readAsDataURL(f);
        }

        $(this).next('.custom-file-label').html($(this)[0].files[0].name);
      }

      //ファイルの取消
      $('.reset').click(function(){
        $(this).parent().prev().children('.custom-file-label').html('ファイルを選択してください...');
        $(this).parent().prev().children('.custom-file-input').val('');
        $(this).parent().parent().parent().children('#preview').remove();
      })

      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>