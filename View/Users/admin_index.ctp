<?php echo $this->element('admin_menu');?>
<?php $this->start('css-embedded'); ?>
<?php $this->end(); ?>
<div class="users index">
	<div class="ib-page-title"><?php echo __('利用者一覧'); ?></div>
	<div class="buttons_container">
		<button type="button" class="btn btn-primary btn-add" onclick="location.href='<?php echo Router::url(array('action' => 'add')) ?>'">+ 追加</button>
	</div>
	<div class="ib-horizontal">
		<?php
			echo $this->Form->create('User', array('action' => 'index'));
			/*
			echo $this->Form->input('group_id',		array(
				'label' => 'グループ : ', 
				'options'=>$groups, 
				'selected'=>$group_id, 
				'empty' => '全て', 
				'required'=>false, 
				'class' => 'form-control',
				'onchange' => '$("#UserIndexForm").submit();'
			));
			*/
			echo $this->Form->input('username',		array('label' => 'ログインID : ', 'required' => false));
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
				<th><?php echo $this->Paginator->sort('username', 'ログインID'); ?></th>
				<th><?php echo $this->Paginator->sort('name', '氏名'); ?></th>
				<!--
				<th><?php echo $this->Paginator->sort('email', 'メールアドレス'); ?></th>
				<th class="ib-col-datetime"><?php echo $this->Paginator->sort('last_logined', '最終ログイン日時'); ?></th>
				-->
				<th class="ib-col-datetime"><?php echo $this->Paginator->sort('modified', '更新日時'); ?></th>
				<th class="ib-col-datetime"><?php echo $this->Paginator->sort('created', '作成日時'); ?></th>
				<th class="ib-col-action"><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['name']); ?></td>
		<!--
		<td><?php echo h($user['User']['email']); ?></td>
		<td class="ib-col-datetime"><?php echo h(Utils::getYMDHN($user['User']['last_logined'])); ?>&nbsp;</td>
		-->
		<td class="ib-col-datetime"><?php echo h(Utils::getYMDHN($user['User']['modified'])); ?>&nbsp;</td>
		<td class="ib-col-datetime"><?php echo h(Utils::getYMDHN($user['User']['created'])); ?>&nbsp;</td>
		<td class="ib-col-action">
			<button type="button" class="btn btn-success"
				onclick="location.href='<?php echo Router::url(array('action' => 'edit', $user['User']['id'])) ?>'">編集</button>
			<?php

echo $this->Form->postLink(__('削除'), array(
				'action' => 'delete',
				$user['User']['id']
		), array(
				'class' => 'btn btn-danger'
		), __('[%s] を削除してもよろしいですか?', $user['User']['name']));
		?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<?php echo $this->element('paging');?>
</div>