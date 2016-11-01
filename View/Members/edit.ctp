<?php echo $this->Html->css( 'select2.min.css');?>
<?php echo $this->Html->script( 'select2.min.js');?>
<?php 
	if($this->action=='edit')
	{
		echo $this->element('menu');
	}
?>
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
		background	: #31708f;
		color		: white;
		padding		: 5px;
	}
	
	.show-item
	{
		padding-top	: 7px;
	}
	
	#MemberZip
	{
		width		: 120px;
		float		: left;
	}
	
	#btnSearchAddress
	{
		float		: left;
		margin		: 3px;
	}
</style>
<?php $this->end(); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
	$(function (e) {
		$('#GroupGroup').select2({placeholder:   "所属するグループを選択して下さい。(複数選択可)",});
		$('#EventEvent').select2({placeholder: "受講するコースを選択して下さい。(複数選択可)",});
		// パスワードの自動復元を防止
		setTimeout('$("#StudentNewPassword").val("");',100);
		
		$("#MemberZip").parent().append('<input id="btnSearchAddress" type="button" value="住所検索" onclick="setAddress();">');
	});
	
	
	function setAddress()
	{
		var zip = $('#MemberZip').val();

		if(zip=="")
		{
			alert("郵便番号が入力されていません");
			return;
		}

		$.ajax({
			type : 'get',
			url : 'https://maps.googleapis.com/maps/api/geocode/json',
			crossDomain : true,
			dataType : 'json',
			data : {
				address : zip,
				language : 'ja',
				sensor : false
			},
			success : function(resp)
			{
				if(resp.status == "OK") {
					// APIのレスポンスから住所情報を取得
					var obj = resp.results[0].address_components;
					
					if (obj.length < 5)
					{
						alert('正しい郵便番号を入力してください');
						return false;
					}
					
					//$('#country').val(obj[4]['long_name']); // 国
					$('#MemberPrefecture').val(obj[3]['long_name']); // 都道府県
					$('#MemberAddress1').val(obj[2]['long_name'] + obj[1]['long_name']);	// 市区町村 + 番地
				}
				else
				{
					alert('住所情報が取得できませんでした');
					return false;
				}
			}
		});
	}
<?php $this->Html->scriptEnd(); ?>
<div class="users form">
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php echo ($this->action == 'edit') ? __('会員情報') :  __('入会申込'); ?>
		</div>
		<div class="panel-body">
			<?php echo $this->Form->create('Member', Configure::read('form_defaults')); ?>
			<?php
				echo $this->Form->input('id');
				
				if($this->action == 'edit')
				{
					Utils::showItem('会員番号',		$member['Member']['username']);
					Utils::showItem('氏名',			$member['Member']['name']);
					Utils::showItem('カナ',			$member['Member']['kana']);
					Utils::showItem('国籍',			$member['Nation']['title']);
					Utils::showItem('生年月日',		$member['Member']['birthday']);
				}
				else
				{
					echo $this->Form->input('name',					array('label' => __('氏名')));
					echo $this->Form->input('kana',					array('label' => __('カナ')));
					echo $this->Form->input('nation_id',			array('label' => __('国籍')));
					echo $this->Form->input('birthday', array(
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
				}
				
				
				echo getBlockTag('勤務先・在学先');
				echo $this->Form->input('work_name1',			array('label' => __('企業 / 学校名')));
				echo $this->Form->input('work_name2',			array('label' => __('部署・課 / 学部・学科')));
				echo $this->Form->input('work_title',			array('label' => __('役職')));
				echo $this->Form->input('work_zip',				array('label' => __('郵便番号')));
				echo $this->Form->input('work_prefecture',		array('label' => __('都道府県')));
				echo $this->Form->input('work_address1',		array('label' => __('住所1')));
				echo $this->Form->input('work_address2',		array('label' => __('住所2')));
				echo $this->Form->input('work_tel_no',			array('label' => __('電話番号')));
				echo $this->Form->input('work_fax_no',			array('label' => __('FAX番号')));
				
				echo getBlockTag('自宅');
				echo $this->Form->input('zip',					array('label' => __('郵便番号')));
				echo $this->Form->input('prefecture',			array('label' => __('都道府県')));
				echo $this->Form->input('address1',				array('label' => __('住所1')));
				echo $this->Form->input('address2',				array('label' => __('住所2')));
				echo $this->Form->input('tel_no',				array('label' => __('電話番号')));
				echo $this->Form->input('fax_no',				array('label' => __('FAX番号')));
				echo $this->Form->input('email',				array('label' => __('メールアドレス')));
				
				echo getBlockTag('最終学歴');
				echo $this->Form->input('school',				array('label' => __('学校名')));
				echo $this->Form->input('department',			array('label' => __('研究科、学部名')));
				echo $this->Form->input('event',				array('label' => __('専攻、学科')));
				echo $this->Form->input('degree',				array('label' => __('既得学位')));
				
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

				if($this->action == 'add')
				{
					echo getBlockTag('紹介者情報');
					echo $this->Form->input('intro_username',		array('label' => __('会員番号')));
					echo $this->Form->input('intro_name',			array('label' => __('氏名')));
				}
				
				// 入会申込の場合のみ表示
				if($this->action=='add')
				{
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
				}

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
					<?php echo $this->Form->submit(($this->action == 'edit') ? __('更新') :  __('入会申込'), Configure::read('form_submit_defaults')); ?>
					<button class="btn btn-default" onclick="location.href='<?php echo Configure::read('website_url');?>'">キャンセル</button>
				</div>
			</div>
		</div>
	</div>
</div>
