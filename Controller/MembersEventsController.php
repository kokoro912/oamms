<?php
/**
 * OCoMMS Project
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
		// 受講コース情報の取得
		$this->MembersEvent->recursive = 0;
		$events = $this->MembersEvent->find('all', 
				array(
						'conditions' => array(
								'MembersEvent.member_id ' => $this->Session->read('Auth.User.id')
						)
				));
		
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
		// 検索条件設定
		$this->Prg->commonProcess();
		
		$conditions = $this->MembersEvent->parseCriteria($this->Prg->parsedParams());
		
		$status			= (isset($this->request->query['status'])) ? $this->request->query['status'] : "";
		$event_id		= (isset($this->request->query['event_id'])) ? $this->request->query['event_id'] : "";
		$member_id		= (isset($this->request->query['member_id'])) ? $this->request->query['member_id'] : "";
		$contenttitle	= (isset($this->request->query['contenttitle'])) ? $this->request->query['contenttitle'] : "";
		
		if($status != "")
			$conditions['MembersEvent.status'] = $status;
		
		if($event_id != "")
			$conditions['Event.id'] = $event_id;
		
		if($member_id != "")
			$conditions['Member.id'] = $member_id;
		
		$from_date	= (isset($this->request->query['from_date'])) ? 
			$this->request->query['from_date'] : 
				array(
					'year' => date('Y', strtotime("-1 month")),
					'month' => date('m', strtotime("-1 month")), 
					'day' => date('d', strtotime("-1 month"))
				);
		
		// debug($from_date);
		
		$to_date	= (isset($this->request->query['to_date'])) ? 
			$this->request->query['to_date'] : 
				array('year' => date('Y'), 'month' => date('m'), 'day' => date('d'));
		
		// debug($to_date);
		
		// 学習日付による絞り込み
		$conditions['MembersEvent.created BETWEEN ? AND ?'] = array(
			implode("/", $from_date), 
			implode("/", $to_date).' 23:59:59'
		);
		
		if($contenttitle != "")
			$conditions['Content.title like'] = '%'.$contenttitle.'%';
		
		$this->Paginator->settings['conditions'] = $conditions;
		$this->Paginator->settings['order']      = 'MembersEvent.created desc';
		$this->MembersEvent->recursive = 0;
		
		//$groups = $this->Group->getGroupList();
		$this->set('members_events',	$this->Paginator->paginate());
		
//		$this->Group = new Group();
		$this->Event = new Event();
		
//		$this->set('groups',			$this->Group->find('list'));
		$this->set('events', 			$this->Event->find('list'));
		$this->set('status',			$status);
		$this->set('event_id',			$event_id);
		$this->set('member_id',			$member_id);
		$this->set('contenttitle',		$contenttitle);
		$this->set('from_date',			$from_date);
		$this->set('to_date',			$to_date);
	}
}
