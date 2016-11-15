<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

//$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo SessionHelper::read('Setting.title')?>
	</title>
	
	<?php
		if(
			($this->params['admin']!=1)||
			($this->params['action']=='admin_login')
		)
		{
			echo '<meta name="viewport" content="width=device-width,initial-scale=1">';
		}
		
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');
		echo $this->Html->css('jquery-ui');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('common');

		echo $this->Html->script('jquery-1.9.1.min.js');
		echo $this->Html->script('jquery-ui-1.9.2.min.js');
		echo $this->Html->script('bootstrap.min.js');
		echo $this->Html->script('moment.js');
		echo $this->Html->script('common.js');
		
		// デモ実施用JavaScript
		if(strpos(FULL_BASE_URL, 'demo') > 0)
			echo $this->Html->script('demo.js');
		
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<?php echo $this -> fetch( 'css-embedded' ); ?>
	<?php echo $this -> fetch( 'script-embedded' ); ?>
	<script>
	setTimeout(function() {
		$('#flashMessage').fadeOut("slow");
	}, 1200);
	</script>
	<style>
		.ib-theme-color
		{
			background-color	: <?php echo SessionHelper::read('Setting.color')?>;
			color				: white;
		}
		
		.ib-logo a
		{
			color				: white;
			text-decoration		: none;
		}
	</style>
</head>
<body>
	<div class="header ib-theme-color">
		<div class="ib-logo ib-left">
			<a href="<?php echo $this->Html->url('/')?>"><?php echo SessionHelper::read('Setting.title')?></a>
		</div>
<?php
		if($loginedUser)
		{
			echo '<div class="ib-navi-item ib-right">'.$this->Html->link('ログアウト', $logoutURL).'</div>';
			echo '<div class="ib-navi-sepa ib-right"></div>';
			
			if(isset($this->request->params['admin']))
			{
				echo '<div class="ib-navi-item ib-right">'.$this->Html->link(__('設定'), array('controller' => 'users', 'action' => 'setting')).'</div>';
			}
			else
			{
				echo '<div class="ib-navi-item ib-right">'.$this->Html->link(__('設定'), array('controller' => 'members', 'action' => 'setting')).'</div>';
			}
			
			echo '<div class="ib-navi-sepa ib-right"></div>';
			echo '<div class="ib-navi-item ib-right">ようこそ '.$loginedUser["name"].' さん </div>';
		}
?>
	</div>
	
	<div id="container">
		<div id="header" class="row">
		</div>
		<div id="content" class="row">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer" class="row">
		</div>
	</div>
	
	<div class="footer ib-theme-color text-center">
		<?php echo SessionHelper::read('Setting.copyright')?>
	</div>
	
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
