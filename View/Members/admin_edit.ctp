<?php echo $this->element('admin_menu');?>
<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php $this->start('css-embedded'); ?>
<style type='text/css'>
	#EventsMemberFromDateYear,
	#EventsMemberToDateYear
	{
		width		: 100px;
	}
	
	.date
	{
		width		: 100px;
	}
	
	.block-title
	{
		background: #31708f;
		color: white;
		padding: 5px;
	}
</style>
<?php $this->end(); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#GroupGroup').select2({placeholder:   "所属するグループを選択して下さい。(複数選択可)",});
		// パスワードの自動復元を防止
		setTimeout('$("#MemberNewPassword").val("");',100);
	});
<?php $this->Html->scriptEnd(); ?>
<div class="users form">
<?php echo $this->Html->link(__('<< 戻る'), array('action' => 'index'))?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo ($this->action == 'admin_edit') ? __('編集') :  __('新規グループ'); ?>
		</div>
		<div class="panel-body">
			<?php echo $this->Form->create('Member', Configure::read('form_defaults')); ?>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('username',				array('label' => '会員番号'));
				echo $this->Form->input('new_password',			array('label' => 'パスワード', 'type' => 'password', 'autocomplete' => 'off'));
				echo $this->Form->input('name',					array('label' => '氏名'));
				echo $this->Form->input('kana',					array('label' => 'カナ'));
				echo $this->Form->input('nation_id',			array('label' => '国籍'));
				echo $this->Form->input('birth_day', array(
					'type' => 'date',
					'dateFormat' => 'YMD',
					'monthNames' => false,
					'minYear' => date('Y') - 100,
					'maxYear' => date('Y'),
					'separator' => ' / ',
					'label'=> '生年月日 : ',
					'class'=>'form-control date',
					'style' => 'display: inline;',
				));
				
				echo $this->Form->input('gender',	array(
					'type' => 'radio',
					'before' => '<label class="col col-md-3 col-sm-4 control-label">性別</label>',
					'separator'=>"　", 
					'disabled'=>false, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('gender')
					)
				);
				
				
				echo getBlockTag('勤務先・在学先');
				echo $this->Form->input('work_name1',			array('label' => '企業 / 学校名'));
				echo $this->Form->input('work_name2',			array('label' => '部署・課 / 学部・学科'));
				echo $this->Form->input('work_title',			array('label' => '役職'));
				echo $this->Form->input('work_zip',				array('label' => '郵便番号'));
				echo $this->Form->input('work_prefecture',		array('label' => '都道府県'));
				echo $this->Form->input('work_address1',		array('label' => '住所1'));
				echo $this->Form->input('work_address2',		array('label' => '住所2'));
				echo $this->Form->input('work_tel_no',			array('label' => '電話番号'));
				echo $this->Form->input('work_fax_no',			array('label' => 'FAX番号'));
				
				echo getBlockTag('自宅');
				echo $this->Form->input('zip',					array('label' => '郵便番号'));
				echo $this->Form->input('prefecture',			array('label' => '都道府県'));
				echo $this->Form->input('address1',				array('label' => '住所1'));
				echo $this->Form->input('address2',				array('label' => '住所2'));
				echo $this->Form->input('tel_no',				array('label' => '電話番号'));
				echo $this->Form->input('fax_no',				array('label' => 'FAX番号'));
				echo $this->Form->input('email',				array('label' => 'メールアドレス'));
				
				echo getBlockTag('最終学歴');
				echo $this->Form->input('school',				array('label' => '学校名'));
				echo $this->Form->input('department',			array('label' => '研究科、学部名'));
				echo $this->Form->input('event',				array('label' => '専攻、学科'));
				echo $this->Form->input('degree',				array('label' => '既得学位'));
				
				echo $this->Form->input('graduated', array(
					'type' => 'date',
					'dateFormat' => 'YM',
					'monthNames' => false,
					'minYear' => date('Y') - 100,
					'maxYear' => date('Y'),
					'separator' => ' / ',
					'label'=> '卒業・修了（予定）年月',
					'class'=>'form-control date',
					'style' => 'display: inline;',
				));
				
				echo $this->Form->input('comment',				array('label' => '備考'));

				echo getBlockTag('紹介者情報');
				echo $this->Form->input('intro_username',		array('label' => '会員番号'));
				echo $this->Form->input('intro_name',			array('label' => '氏名'));
				
				echo $this->Form->input('member_kind',	array(
					'type' => 'radio',
					'before' => '<label class="col col-md-3 col-sm-4 control-label">会員種別</label>',
					'separator'=>"　", 
					'disabled'=>false, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('member_kind')
					)
				);

				echo $this->Form->input('subscription',	array(
					'type' => 'radio',
					'before' => '<label class="col col-md-3 col-sm-4 control-label">メルマガ</label>',
					'separator'=>"　", 
					'disabled'=>false, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('subscription')
					)
				);

				echo $this->Form->input('send_type',	array(
					'type' => 'radio',
					'before' => '<label class="col col-md-3 col-sm-4 control-label">郵送物送付先</label>',
					'separator'=>"　", 
					'disabled'=>false, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('send_type')
					)
				);

				echo $this->Form->input('status',	array(
					'type' => 'radio',
					'before' => '<label class="col col-md-3 col-sm-4 control-label">ステータス</label>',
					'after' => '<font color="red">'.__('※ 承認に変更すると会員に承認完了メールが送信されます').'</font>',
					'separator'=>"　", 
					'disabled'=>false, 
					'legend' => false,
					'class' => false,
					'options' => Configure::read('member_status')
					)
				);

				echo $this->Form->input('Group',				array('label' => '所属グループ',	'size' => 20));
				
				// 承認モード判定用
				if($this->request->data['Member']['status']=='0')
					echo $this->Form->hidden('mode', array('id'=>'mode', 'value'=>'is_apply'));
				
				function getBlockTag($title)
				{
					$tag = 
						'<div class="form-group">'.
						'  <div class="col col-md-3 col-sm-4"></div>'.
						'  <div class="col col-md-9 col-sm-8"><div class="block-title">'.$title.'</div></div>'.
						'</div>';
					
					return $tag;
				}
			?>
			<div class="form-group">
				<div class="col col-md-9 col-md-offset-3">
					<?php echo $this->Form->submit('保存', Configure::read('form_submit_defaults')); ?>
				</div>
			</div>
		</div>
	</div>
</div>
