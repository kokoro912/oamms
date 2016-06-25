<div class="users form">
	<div class="panel panel-danger form-signin">
		<div class="panel-heading">
			管理者ログイン
		</div>
		<div class="panel-body">
			<div class="text-right"><a href="../../members/login"><?php echo __("会員ログインへ"); ?></a></div>
			<?php echo $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create('User'); ?>
			
			<div class="form-group">
				<?php echo $this->Form->input('username', array('label' => 'ユーザID', 'class'=>'form-control')); ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('password', array('label' => 'パスワード', 'class'=>'form-control'));?>
			</div>
			<?php echo $this->Form->end(array('label' => 'ログイン', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
		</div>
	</div>
</div>
