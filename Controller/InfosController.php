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
 * Infos Controller
 *
 * @property Info $Info
 * @property PaginatorComponent $Paginator
 */
class InfosController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array(
			'Paginator'
	);

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->loadModel('MembersGroup');
		
		// 全体のお知らせの取得
		App::import('Model', 'Setting');
		$this->Setting = new Setting();
		
		$info = $this->Setting->find('all',
				array(
						'conditions' => array(
								'Setting.setting_key' => 'information'
						)
				));
		
		$this->set('info', $info[0]);
		
		// 自分の所属しているグループ一覧を取得
		$groups = $this->MembersGroup->find('all', array(
			'conditions' => array(
				'member_id' => $this->Session->read('Auth.User.id')
			)
		));
		
		// 自分自身が所属するグループのIDの配列を作成
		$group_id_list = array();
		
		foreach ($groups as $group)
		{
			$group_id_list[count($group_id_list)] = $group['MembersGroup']['id'];
		}
		
		// グループ設定されていない、もしくは自分の所属するグループあてお知らせのみを取得する
		$this->paginate = array(
			'Info' => array(
				'fields' => array('*', 'InfoGroup.group_id'),
				'conditions' => array('OR' => array(
					array('InfoGroup.group_id' => null), 
					array('InfoGroup.group_id' => $group_id_list)
				)),
				'limit' => 20,
				'joins' => array(
					array(
						'type' => 'LEFT OUTER',
						'alias' => 'InfoGroup',
						'table' => 'ib_infos_groups',
						'conditions' => 'Info.id = InfoGroup.info_id'
					),
				),
				'group' => array('Info.id'),
			)
		);
		
		$infos = $this->paginate();
		
		$this->set('infos', $infos);
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null)
	{
		if (! $this->Info->exists($id))
		{
			throw new NotFoundException(__('Invalid info'));
		}
		$options = array(
				'conditions' => array(
						'Info.' . $this->Info->primaryKey => $id
				)
		);
		$this->set('info', $this->Info->find('first', $options));
	}

	public function admin_index()
	{
		$this->Paginator->settings = array(
			'limit' => 10,
			'order' => 'Info.created desc',
		);
		
		$result = $this->paginate();
		$this->set('infos', $result);
	}

	public function admin_add()
	{
		$this->admin_edit();
		$this->render('admin_edit');
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function admin_edit($id = null)
	{
		if ($this->action == 'admin_edit' && ! $this->Info->exists($id))
		{
			throw new NotFoundException(__('Invalid info'));
		}
		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			if ($this->Info->save($this->request->data))
			{
				$this->Flash->success(__('お知らせが保存されました'));
				return $this->redirect(array(
						'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The info could not be saved. Please, try again.'));
			}
		}
		else
		{
			$options = array(
					'conditions' => array(
							'Info.' . $this->Info->primaryKey => $id
					)
			);
			$this->request->data = $this->Info->find('first', $options);
		}
		//$users = $this->Info->User->find('list');

		$this->Group = new Group();
		
		$groups = $this->Group->find('list');
		$this->set(compact('groups'));
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function admin_delete($id = null)
	{
		$this->Info->id = $id;
		if (! $this->Info->exists())
		{
			throw new NotFoundException(__('Invalid info'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Info->delete())
		{
			$this->Flash->success(__('お知らせが削除されました'));
		}
		else
		{
			$this->Flash->error(__('The info could not be deleted. Please, try again.'));
		}
		return $this->redirect(array(
				'action' => 'index'
		));
	}
}
