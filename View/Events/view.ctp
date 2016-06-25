<?php echo $this->element('menu');?>
<?php $this->start('css-embedded'); ?>
<style>
.btn-rest
{
	float: right;
}
.form-group div
{
	padding: 7px;
}

</style>
<?php $this->end(); ?>

<?php
//debug($event);
?>
<div class="ib-breadcrumb">
<?php
$this->Html->addCrumb('<< イベント覧', array(
		'controller' => 'members_events',
		'action' => 'index'
));

echo $this->Html->getCrumbs(' / ');
?>
</div>
<div class="usersEvents index">
	<div class="panel panel-info">
	<div class="panel-heading">イベント詳細</div>
	<div class="panel-body">
		<?php echo $this->Form->create('Event', Configure::read('form_defaults')); ?>
		<div class="form-group">
			<label class="col col-md-3 col-sm-4 control-label">イベント名</label>
			<div class="col col-md-9 col-sm-8">
				<?php echo h($event['Event']['title']); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col col-md-3 col-sm-4 control-label">開催日時</label>
			<div class="col col-md-9 col-sm-8">
				<?php echo h($event['Event']['started']); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col col-md-3 col-sm-4 control-label">申込受付日時</label>
			<div class="col col-md-9 col-sm-8">
				<?php echo h($event['Event']['opened']); ?> ～
				<?php echo h($event['Event']['closed']); ?>
			</div>
		</div>
		<div class="form-group">
			<label class="col col-md-3 col-sm-4 control-label">詳細内容</label>
			<div class="col col-md-9 col-sm-8">
				<?php echo nl2br($event['Event']['content']); ?>
			</div>
		</div>
		<div class="form-group">
			<div class="col col-md-9 col-md-offset-3">
				<?php
				echo $this->Form->hidden('id', array('id'=>'', 'class'=>'event_id', 'value'=>$event['Event']['id']));
				?>
				<?php
					$today	= strtotime(date('Y-m-d'));
					$opened	= strtotime($event['Event']['opened']);
					$closed	= strtotime($event['Event']['closed']);
					
					// 申込期間内の場合
					if(
						($today >= $opened)&&
						($today <= $closed)
					)
					{
						if($history)
						{
							echo $this->Form->hidden('mode', array('id'=>'mode', 'value'=>'cancel'));
							echo $this->Form->submit('申込をキャンセル', Configure::read('form_submit_defaults'));
						}
						else
						{
							echo $this->Form->hidden('mode', array('id'=>'mode', 'value'=>'apply'));
							echo $this->Form->submit('申込', Configure::read('form_submit_defaults'));
						}
					}
				?>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
	</div>
</div>
