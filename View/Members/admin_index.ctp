<?php echo $this->element('admin_menu');?>
<?php $this->start('css-embedded'); ?>
<?php $this->end(); ?>
<div class="members index">
	<div class="ib-page-title"><?php echo __('会員一覧'); ?></div>
	<div class="buttons_container">
		<button type="button" class="btn btn-primary btn-add" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
	</div>
	<div class="ib-horizontal">
		<?php
			echo $this->Form->create('Member',	array('action' => 'index'));
			echo $this->Form->input('group_id',	array(
				'label' => '会員種別 : ', 
				'options'=>Configure::read('member_kind'), 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'onchange' => '$("#MemberIndexForm").submit();'
			));
			echo $this->Form->input('status',	array(
				'label' => 'ステータス : ', 
				'options'=>Configure::read('member_status'), 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'onchange' => '$("#MemberIndexForm").submit();'
			));
			echo $this->Form->input('membername',		array('label' => '会員番号 : ', 'required' => false));
			echo $this->Form->input('name',			array('label' => '氏名 : '  , 'required' => false, 'value'=>$name));
		?>
		<input type="submit" class="btn btn-info btn-add" value="検索">
		<?php
			echo $this->Form->end();
		?>
	</div>
	<table>
		<thead>
			<tr>
				<th><?php echo $this->Paginator->sort('username',		'会員番号'); ?></th>
				<th><?php echo $this->Paginator->sort('name',			'氏名'); ?></th>
				<th><?php echo $this->Paginator->sort('member_kind',	'会員種別'); ?></th>
				<th><?php echo $this->Paginator->sort('joined',			'入会日'); ?></th>
				<th><?php echo $this->Paginator->sort('work_name1',		'所属1'); ?></th>
				<th><?php echo $this->Paginator->sort('status',			'ステータス'); ?></th>
				<th class="ib-col-action"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($members as $member): ?>
	<tr>
		<td><?php echo h($member['Member']['username']); ?>&nbsp;</td>
		<td><?php echo h($member['Member']['name']); ?></td>
		<td><?php echo h(Configure::read('member_kind.'.$member['Member']['member_kind'])); ?>&nbsp;</td>
		<td><?php echo h($member['Member']['joined']); ?>&nbsp;</td>
		<td><?php echo h($member['Member']['work_name1']); ?>&nbsp;</td>
		<td><?php echo h(Configure::read('member_status.'.$member['Member']['status'])); ?>&nbsp;</td>
		<td class="ib-col-action">
			<button type="button" class="btn btn-success"
				onclick="location.href='<?php echo Router::url(array('action' => 'edit', $member['Member']['id'])) ?>'">編集</button>
			<?php
//debug($member);
echo $this->Form->postLink(__('削除'), array(
				'action' => 'delete',
				$member['Member']['id']
		), array(
				'class' => 'btn btn-danger'
		), __('[%s] を削除してもよろしいですか?', $member['Member']['name']));
		?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>