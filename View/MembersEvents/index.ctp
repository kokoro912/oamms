<?php echo $this->element('menu');?>
<?php $this->start('css-embedded'); ?>
<style>
.btn-rest
{
	float: right;
}

@media only screen and (max-width:800px)
{
	a
	{
		display: block;
	}
	
	.list-group-item-text span
	{
		display: block;
	}
}
</style>
<?php $this->end(); ?>
<div class="events index">
	<div class="panel panel-info">
	<div class="panel-heading"><?php echo __('イベント一覧'); ?></div>
	<div class="panel-body">
		<ul class="list-group">
		<?php foreach ($events as $event): ?>
		<?php //debug($event)?>
			<a href="<?php echo Router::url(array('controller' => 'events', 'action' => 'view', $event['Event']['id']));?>" class="list-group-item">
				<?php
				if($event['ApplyCount']['apply_count'] > 0)
				{
					echo '<button type="button" class="btn btn-info btn-rest">申込済</button>';
				}
				else
				{
					$today	= strtotime(date('Y-m-d'));
					$closed	= strtotime($event['Event']['closed']);
					
					if($today > $closed)
					{
						echo '<button type="button" class="btn btn-default btn-rest">受付終了</button>';
					}
					else
					{
						echo '<button type="button" class="btn btn-danger btn-rest">申込受付中</button>';
					}
				}
				?>
				<h4 class="list-group-item-heading"><?php echo h($event['Event']['title']);?></h4>
				<p class="list-group-item-text">
					<span>開催期間: <?php echo h(Utils::getYMD($event['Event']['started'])); ?></span><br>
					<span>申込期間: <?php echo h(Utils::getYMD($event['Event']['opened'])); ?>～<?php echo h(Utils::getYMD($event['Event']['closed'])); ?></span>
				</p>
			</a>
		<?php endforeach; ?>
		<?php //echo $no_members_events;?>
		</ul>
	</div>
	</div>
</div>
