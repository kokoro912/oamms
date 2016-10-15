  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <!--
        <a class="navbar-brand" href="#">OAMMS</a>
        -->
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
<?php
$is_active = (($this->name=='Members')&&($this->params["action"]!='admin_password')) ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('会員'), array('controller' => 'members', 'action' => 'index')).'</li>';

$is_active = (($this->name=='Users')&&($this->params["action"]!='admin_password')) ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('利用者'), array('controller' => 'users', 'action' => 'index')).'</li>';

$is_active = ($this->name=='Infos') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('お知らせ'), array('controller' => 'infos', 'action' => 'index')).'</li>';

$is_active = ($this->name=='Groups') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('グループ'), array('controller' => 'groups', 'action' => 'index')).'</li>';

$is_active = (($this->name=='Events')||($this->name=='Contents')||($this->name=='ContentsQuestions')) ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('イベント'), array('controller' => 'events', 'action' => 'index')).'</li>';

$is_active = ($this->name=='MembersEvents') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('イベント申込履歴'), array('controller' => 'members_events', 'action' => 'index')).'</li>';

$is_active = ($this->name=='Settings') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('システム設定'), array('controller' => 'settings', 'action' => 'index')).'</li>';
?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
