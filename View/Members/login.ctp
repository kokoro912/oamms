<?php $this->start('css-embedded'); ?>
	<style type='text/css'>
		#remember_me
		{
			margin-left	: 10px;
		}
	</style>
<?php $this->end(); ?>
<div class="users form">
	<div class="panel panel-default form-signin">
		<div class="panel-heading">
			<?php echo __("会員ログイン"); ?>
		</div>
		<div class="panel-body">
			<div class="text-right"><a href="../admin/users/login"><?php echo __("管理者ログインへ"); ?></a></div>
			<?php echo $this->Flash->render('auth'); ?>
			<?php echo $this->Form->create('Member'); ?>
			
			<div class="form-group">
				<?php echo $this->Form->input('username', array('label' => __('会員番号'), 'class'=>'form-control')); ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('password', array('label' => __('パスワード'), 'class'=>'form-control'));?>
				<input type="checkbox" name="data[User][remember_me]" checked="checked" value="1" id="remember_me"><?php echo __('ログイン状態を保持')?>
			</div>
			<?php echo $this->Form->end(array('label' => 'ログイン', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
		</div>
	</div>
</div>
