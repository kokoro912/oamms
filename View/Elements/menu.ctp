  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <ul class="nav navbar-nav">
<?php
$is_active = ($this->name=='Infos') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('お知らせ'), array('controller' => 'infos', 'action' => 'index')).'</li>';

$is_active = (($this->name=='MembersEvents')||($this->name=='Contents')||($this->name=='ContentsQuestions')) ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('イベント'), array('controller' => 'members_events', 'action' => 'index')).'</li>';

$is_active = ($this->name=='Members') ? ' active' : '';
echo '<li class="'.$is_active.'">'.$this->Html->link(__('会員情報編集'), array('controller' => 'members', 'action' => 'edit')).'</li>';

?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </nav>
