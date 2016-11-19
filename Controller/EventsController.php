<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppController', 'Controller');

/**
 * Event コントローラ
 *
 * @property Group $Group
 * @property Content $Content
 * @property ContentsQuestion $ContentsQuestion
 * @property EventsMember $EventsMember
 * @property User $User
 */
class EventsController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
			'Paginator'
	);

	public function admin_index()
	{
		$this->Event->recursive = 0;
		$this->paginate = array(
			'Event' => array(
				'fields' => array('Event.*', 'UserEvent.event_count'),
				'conditions' => array(),
				'limit' => 10,
				'order' => 'created desc',
				'joins' => array(
					array('type' => 'LEFT OUTER', 'alias' => 'UserEvent',
							'table' => '(SELECT event_id, COUNT(*) as event_count FROM ib_members_events GROUP BY event_id)',
							'conditions' => 'Event.id = UserEvent.event_id')
				))
		);

		$result = $this->paginate();
		
		//debug($result);

		//debug($this->paginate);
		$this->set('events', $result);
	}

	public function view($id = null)
	{
		if (! $this->Event->exists($id))
		{
			throw new NotFoundException(__('Invalid event'));
		}
		
		$options = array(
				'conditions' => array(
						'Event.' . $this->Event->primaryKey => $id
				)
		);
		
		$event = $this->Event->find('first', $options);
		
		// イベントの申込履歴を取得
		$this->loadModel('MembersEvent');
		
		$options = array(
			'conditions' => array(
				'MembersEvent.member_id' => $this->Session->read('Auth.User.id'),
				'MembersEvent.event_id'  => $id
			)
		);
		
		$history = $this->MembersEvent->find('first', $options);
		
		$status = ($history) ? $history['MembersEvent']['status'] : 0;
		
		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			debug($this->request->data);
			/*
			$data = array(
				'event_id'    => $id,
				'member_id'   => $this->Session->read('Auth.User.id'),
				'status'      => 0,
			);
			*/
			
			$this->loadModel('MembersEvent');
			
			// イベント申込情報が存在しない場合のみ、新規に作成する
			if(!$history)
			{
				$this->MembersEvent->create();
				$history['MembersEvent']['event_id'] = $id;
				$history['MembersEvent']['member_id'] = $this->Session->read('Auth.User.id');
				$history['MembersEvent']['status'] = 0;
			}
			
			
			// イベント申込
			if($this->request->data['Event']['mode']=='apply')
			{
				$history['MembersEvent']['status'] = 1;
				$this->MembersEvent->save($history);
				$this->Flash->success(__('イベントを申し込みました'));
				return $this->redirect(array(
					'controller' => 'members_events',
					'action' => 'index'
				));
			}
			
			// イベント申込キャンセル
			if($this->request->data['Event']['mode']=='cancel')
			{
				$history['MembersEvent']['status'] = 2;
				$this->MembersEvent->save($history);
				$this->Flash->success(__('申込をキャンセル致しました'));
				return $this->redirect(array(
					'controller' => 'members_events',
					'action' => 'index'
				));
			}

			//debug($this->request->data);
//			if ($this->Event->save($this->request->data))
//			{
//				$this->Flash->success(__('申込が完了しました'));
//				return $this->redirect(array(
//						'action' => 'index'
//				));
//			}
//			else
//			{
//				$this->Flash->error(__('The event could not be saved. Please, try again.'));
//			}
		}
		
		
		$this->set(compact('event', 'history', 'status'));
	}

	public function admin_add()
	{
		$this->admin_edit();
		$this->render('admin_edit');
	}

	public function admin_edit($id = null)
	{
		if ($this->action == 'edit' && ! $this->Event->exists($id))
		{
			throw new NotFoundException(__('Invalid event'));
		}
		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			$this->Event->set($this->data);
			
			if ($this->Event->save($this->request->data))
			{
				$this->Flash->success(__('イベントが保存されました'));
				return $this->redirect(array(
						'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('イベントの保存に失敗しました'));
			}
		}
		else
		{
			$options = array(
					'conditions' => array(
							'Event.' . $this->Event->primaryKey => $id
					)
			);
			$this->request->data = $this->Event->find('first', $options);
		}
		//$users = $this->Event->User->find('list');
	}

	public function admin_delete($id = null)
	{
		$this->Event->id = $id;
		if (! $this->Event->exists())
		{
			throw new NotFoundException(__('Invalid event'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Event->delete())
		{
			$this->Flash->success(__('コースが削除されました'));
		}
		else
		{
			$this->Flash->error(__('The event could not be deleted. Please, try again.'));
		}
		return $this->redirect(array(
				'action' => 'index'
		));
	}


}
