<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController',		'Controller');
App::uses('MembersEvents',		'MembersEvents');
App::uses('Event', 'Event');
App::uses('Group',  'Group');

/**
 * MembersEvents Controller
 *
 * @property MembersEvent $MembersEvent
 * @property PaginatorComponent $Paginator
 */
class MembersEventsController extends AppController
{

	public $components = array(
			'Paginator',
			'Search.Prg'
	);

	//public $presetVars = true;

	public $paginate = array();
	
	public $presetVars = array(
		array(
			'name' => 'name', 
			'type' => 'value',
			'field' => 'Member.name'
		), 
		array(
			'name' => 'membername',
			'type' => 'like',
			'field' => 'Member.membername'
		), 
		array(
			'name' => 'contenttitle', 'type' => 'like',
			'field' => 'Content.title'
		)
	);

	public function index()
	{
		$data = $this->MembersEvent->getMemberEvent( $this->Session->read('Auth.User.id') );
		
		$no_events = "";
		
		if(count($data)==0)
			$no_events = "現在、申込可能なイベントはありません";
		
		$this->set('events',	$data);
		$this->set('no_events',	$no_events);
	}

	// 検索対象のフィルタ設定
	/*
	 * public $filterArgs = array( array('name' => 'name', 'type' => 'value',
	 * 'field' => 'Member.name'), array('name' => 'membername', 'type' => 'like',
	 * 'field' => 'Member.membername'), array('name' => 'title', 'type' => 'like',
	 * 'field' => 'Content.title') );
	 */
	public function admin_index()
	{
		//debug($this->request);
		
		// 検索条件設定
		$this->Prg->commonProcess();

		$conditions = $this->MembersEvent->parseCriteria($this->Prg->parsedParams());

		$status		= (isset($this->request->query['status'])) ? $this->request->query['status'] : "";
		$event_id	= (isset($this->request->query['event_id'])) ? $this->request->query['event_id'] : "";
		$username	= (isset($this->request->query['username']))     ? $this->request->query['username'] : "";

		$conditions = array();

		if($event_id != "")
			$conditions['Event.id'] = $event_id;
		
		if($status != "")
			$conditions['MembersEvent.status'] = $status;

		if($username != "")
			$conditions['Member.username'] = $username;

		$this->Paginator->settings['conditions'] = $conditions;
		$this->Paginator->settings['order']      = 'MembersEvent.created desc';
		
		$members_events = $this->paginate();
		
		$this->Event = new Event();
		$events = $this->Event->find('list');
		
		$this->set(compact('events', 'members_events', 'event_id', 'status', 'username'));
	}


	public function admin_csv($event_id = "", $status = "", $username = "")
	{
		$conditions = array();
		
		if($event_id != "")
			$conditions['Event.id'] = $event_id;
		
		if($status != "")
			$conditions['MembersEvent.status'] = $status;

		if($username != "")
			$conditions['Member.username'] = $username;

		$this->autoRender = false;
		//Configure::write('debug', 0);

		//Content-Typeを指定
		$this->response->type('csv');

		//header("Content-Disposition: attachment; filename=selection.csv")
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="members_event.csv"');
		
		$fp = fopen('php://output','w');
		
		//CSVをエクセルで開くことを想定して文字コードをSJISへ変換
		//stream_filter_append($fp, 'convert.iconv.UTF-8/CP932', STREAM_FILTER_WRITE);
		
		// イベント申込状況を取得
		$options = array(
			'conditions' => $conditions
		);
		
		$rows = $this->MembersEvent->find('all', $options);
		
		$header = array("イベント", "開催期間", "所属", "会員番号", "会員名", "メールアドレス", "申込日時", "ステータス");
		
		mb_convert_variables("SJIS", "UTF-8", $header);
		fputcsv($fp, $header);
		
		foreach($rows as $row)
		{
			$row = array(
				$row['Event']['title'], 
				$row['Event']['started'].'～'.$row['Event']['started'], 
				$row['Member']['work_name1'], 
				$row['Member']['name'], 
				$row['Member']['username'], 
				$row['Member']['name'], 
				$row['Member']['email'], 
				$row['MembersEvent']['created'], 
				Configure::read('apply_status.'.$row['MembersEvent']['status']),
			);
			
			mb_convert_variables("SJIS", "UTF-8", $row);
			
			fputcsv($fp, $row);
		}
		
		fclose($fp);
	}
}
