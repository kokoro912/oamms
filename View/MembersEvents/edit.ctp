<div class="members_events form">
<?php echo $this->Form->create('Record'); ?>
	<fieldset>
		<legend><?php echo __('Edit Record'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('group_id');
		echo $this->Form->input('event_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('content_id');
		echo $this->Form->input('score');
		echo $this->Form->input('borderline');
		echo $this->Form->input('is_passed');
		echo $this->Form->input('is_complete');
		echo $this->Form->input('progress');
		echo $this->Form->input('understanding');
		echo $this->Form->input('study_sec');
	?>
	</fieldset>
<?php echo $this->Form->end(__('•Û‘¶')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Record.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Record.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Records'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Events'), array('controller' => 'events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event'), array('controller' => 'events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contents'), array('controller' => 'contents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Content'), array('controller' => 'contents', 'action' => 'add')); ?> </li>
	</ul>
</div>
