<?php echo $this->element('admin_menu');?>
<?php $this->start('css-embedded'); ?>
<style type='text/css'>
	.date-select
	{
		width		: 80px;
	}
	
	input[type='text'], textarea,
	.form-control, 
	label
	{
		font-size	: 12px;
		font-weight	: normal;
		height		: 30px;
		padding		: 4px;
	}
	
</style>
<?php $this->end(); ?>
<div class="members_events index">
	<div class="ib-page-title"><?php echo __('イベント申込履歴一覧'); ?></div>
	<div class="ib-horizontal">
		<?php
			echo $this->Form->create('MembersEvent', array('action' => 'index'));
			echo $this->Form->input('event_id',		array('label' => 'イベント :', 'options'=>$events, 'selected'=>$event_id, 'empty' => '全て', 'required'=>false, 'class'=>'form-control'));
			echo $this->Form->input('status',		array('label' => 'ステータス :', 'options'=>Configure::read('apply_status'), 'selected'=>$status, 'empty' => '全て', 'required'=>false, 'class'=>'form-control'));
			echo $this->Form->submit(__('検索'),	array('class' => 'btn btn-info'));
//			echo '<br><div class="ib-search-date-container">';
//			echo $this->Form->input('from_date', array(
//				'type' => 'date',
//				'dateFormat' => 'YMD',
//				'monthNames' => false,
//				'timeFormat' => '24',
//				'minYear' => date('Y') - 5,
//				'maxYear' => date('Y'),
//				'separator' => ' / ',
//				'label'=> '申込日時 : ',
//				'class' => 'form-control date-select',
//				'style' => 'display: inline;',
//				'value' => $from_date
//			));
//			echo $this->Form->input('to_date', array(
//				'type' => 'date',
//				'dateFormat' => 'YMD',
//				'monthNames' => false,
//				'timeFormat' => '24',
//				'minYear' => date('Y') - 5,
//				'maxYear' => date('Y'),
//				'separator' => ' / ',
//				'label'=> '～',
//				'class' => 'form-control date-select',
//				'style' => 'display: inline;',
//				'value' => $to_date
//			));
//			echo '</div>';
			echo $this->Form->end();
		?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
		<th><?php echo $this->Paginator->sort('event_id', 'イベント'); ?></th>
		<th><?php echo $this->Paginator->sort('started', '開催期間'); ?></th>
		<th><?php echo $this->Paginator->sort('user_id', '会員名'); ?></th>
		<th><?php echo $this->Paginator->sort('content_id', '申込日時'); ?></th>
		<th><?php echo $this->Paginator->sort('status', 'ステータス'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($members_events as $members_event): ?>
	<tr>
		<td><?php echo h($members_event['Event']['title']); ?>&nbsp;</td>
		<td><?php echo h($members_event['Event']['started']); ?> ～ <?php echo h($members_event['Event']['ended']); ?>&nbsp;</td>
		<td><?php echo h($members_event['Member']['name']); ?>&nbsp;</td>
		<td><?php echo h($members_event['MembersEvent']['created']); ?>&nbsp;</td>
		<td><?php echo h(Configure::read('apply_status.'.$members_event['MembersEvent']['status'])); ?>&nbsp;</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>
