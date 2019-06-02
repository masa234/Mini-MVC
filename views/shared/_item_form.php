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
                    <label for="inputItemname">商品名</label>
                    <input type="text" id="item_name" class="form-control" name="item_name" placeholder="商品名を15文字以内で入力してください" 
                    value="<?=$this->h( $this->get_Value( 'item_name', $item ) ) ?>"required autofocus>
                </div>

                <?php if ( $register_form ): ?>
                <div class="form-group">
                  <label for="inputItemPrice">値段</label>
                  <input type="email" id="item_price" class="form-control" name="item_price" placeholder="商品の値段を入力してください。"
                  value="<?=$this->h( $this->get_Value( 'item_price', $item ) ) ?>"required>
                </div>
                <?php endif; ?>

				<div class="form-group">
                    <label for="inputTag">タグ</label>
                    <input type="text" id="item_tag" class="form-control" name="item_tag" placeholder="商品につけるTagを入力してください。" 
                    value="<?=$this->h( $this->get_Value( 'item_tag', $item ) ) ?>"required autofocus>
                </div>

				<div class="form-group">
                    <label for="inputDetail">商品の説明</label>
                    <input type="text" id="item_detail" class="form-control" name="item_detail" placeholder="商品の説明文を入力してください。" 
                    value="<?=$this->h( $this->get_Value( 'item_detail', $item ) ) ?>"required autofocus>
                </div>


                <?php if ( $register_form ): ?>
                  <input type="file" name="user_img">
                <?php endif; ?>

                <button class="btn btn-lg btn-success btn-block" type="submit" name= "action" ><?=$this->h( BUTTONTEXT ); ?></button>
						  </form>
					  </div>
				  </div>
			  </div>
		  </div>
    </div><!-- /container -->