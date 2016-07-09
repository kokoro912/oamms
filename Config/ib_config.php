<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */


$config['group_status']		= array('1' => '公開', '0' => '非公開');
$config['course_status']	= array('1' => '有効', '0' => '無効');
$config['gender']			= array('M' => '男性', 'W' => '女性');
$config['member_status']	= array('0' => '未承認', '1' => '承認', '2' => '却下');
$config['member_kind']		= array(
	'1'		=> '正会員',
	'2'		=> '準会員',
	'3'		=> '学生会員',
	'4'		=> '賛助会員',
);
$config['subscription']		= array('0' => '購読しない', '1' => '購読する');
$config['send_type']		= array('0' => '自宅', '1' => '勤務先');
$config['apply_status']		= array('0' => '申込', '1' => 'キャンセル');

// フォームのスタイル(BoostCake)の基本設定
$config['form_defaults'] = array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 col-sm-4 control-label'
		),
		'wrapInput' => 'col col-md-9 col-sm-8',
		'class' => 'form-control'
	),
	'class' => 'form-horizontal'
);

$config['form_submit_defaults'] = array(
	'div' => false,
	'class' => 'btn btn-primary'
);


$config['theme_colors']   = array(
	'#337ab7' => 'default',
	'#101010' => 'ocomms',
	'#006888' => 'marine blue',
	'#003f8e' => 'ink blue',
	'#00a960' => 'green',
	'#288c66' => 'forest green',
	'#006948' => 'holly green',
	'#ea5550' => 'red',
	'#ea5550' => 'poppy red',
	'#ee7800' => 'orange',
	'#fcc800' => 'chrome yellow',
	'black' => 'black',
	'#7d7d7d' => 'gray'
);

