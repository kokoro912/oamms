<?php $this->start('css-embedded'); ?>
<style type='text/css'>
	.panel
	{
	}
	
	.msg
	{
		margin		: 100px;
		text-align	: center;
	}
</style>
<?php $this->end(); ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<?php echo __('入会申込'); ?>
	</div>
	<div class="panel-body">
		<div class="msg">
			<p>入会申込を受け付けました。</p>
			<p>ご連絡があるまでしばらくお待ちください。</p>
			<button class="btn btn-default" onclick="location.href='../webroot/website/'">戻る</button>
		</div>
	</div>
</div>

