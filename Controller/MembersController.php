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
App::uses('Group', 'Group');

/**
 * Members Controller
 *
 * @property Member $Member
 * @property PaginatorComponent $Paginator
 */
class MembersController extends AppController
{

	public $components = array(
			'Session',
			'Paginator',
			'Search.Prg',
			'Cookie',
			'Auth' => array(
					'allowedActions' => array(
							'index',
							'login',
							'add',
							'thanks',
							'mail'
					)
			)
	);

	public function beforeFilter()
	{
		parent::beforeFilter();
		// ユーザー自身による登録とログアウトを許可する
		$this->Auth->allow('add', 'logout');

		// 設定を中に記述
		$this->Auth->authenticate = array(
			'Basic' => array('userModel' => 'Member'),
			'Form' => array('userModel' => 'Member')
		);
	}

	public function index()
	{
		$this->redirect("/infos");
	}

	public function view($id = null)
	{
		if (! $this->Member->exists($id))
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array(
				'conditions' => array(
						'Member.' . $this->Member->primaryKey => $id
				)
		);
		$this->set('user', $this->Member->find('first', $options));
	}

	public function setting()
	{
		$this->admin_setting();
	}

	public function admin_delete($id = null)
	{
		$this->Member->id = $id;
		if (! $this->Member->exists())
		{
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Member->delete())
		{
			$this->Flash->success(__('ユーザが削除されました'));
		}
		else
		{
			$this->Flash->error(__('ユーザを削除できませんでした'));
		}
		return $this->redirect(array(
				'action' => 'index'
		));
	}

	public function logout()
	{
		$this->Cookie->delete('Auth');
		$this->redirect($this->Auth->logout());
	}

	public function login()
	{
		// Check cookie's login info.
		if ( $this->Cookie->check('Auth') )
		{
			$this->request->data = $this->Cookie->read('Auth');

			if ( $this->Auth->login() )
			{
				return $this->redirect( $this->Auth->redirect());
			}
			else
			{
				// Delete cookies
				$this->Cookie->delete('Auth');
			}
		}

		if ($this->request->is('post'))
		{
			//debug($this->request);
			if ($this->Auth->login())
			{
				if (isset($this->data['Member']['remember_me']))
				{
					// Remove remember_me data.
					unset( $this->request->data['Member']['remember_me']);

					// Save login info to cookie.
					$cookie = $this->request->data;
					$this->Cookie->write( 'Auth', $cookie, true, '+2 weeks');
				}

				$this->Member->id = $this->Auth->user('id');
				// 最終ログイン日時を保存
				$this->Member->saveField('last_logined', date(DATE_ATOM));
				$this->writeLog('user_logined', '');
				$this->Session->delete('Auth.redirect');
				$this->redirect($this->Auth->redirect());
			}
			else
			{
				$this->Flash->error(__('入力されたID、もしくはパスワードが正しくありません'));
			}
		}
	}

	public function add()
	{
		$this->edit();
		$this->render('edit');
	}

	public function edit()
	{
		$id = $this->Session->read('Auth.User.id');

		if ($this->action == 'edit' && !$this->Member->exists($id))
		{
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			if ($this->Member->save($this->request->data))
			{
				if($this->action == 'add')
				{
					$name	= $this->request->data['Member']['name'];
					$mail	= $this->request->data['Member']['email'];
					$admin_from	= Configure :: read('admin_from');
					$admin_to	= Configure :: read('admin_to');
					
					$params = array(
						'name' => $name,
					);
					
					// 申込者へメール送信
					$email = new CakeEmail();
					$email->from($admin_from);
					$email->to($mail);
					$email->subject('[OAMMS]入会申込受付メール');
					$email->template('apply');
					$email->viewVars($params);
					$email->send();
					
					// 管理者へメール送信
					$email = new CakeEmail();
					$email->from($admin_from);
					$email->to($admin_to);
					$email->subject('[OAMMS]入会申込通知メール');
					$email->template('admin_apply');
					$email->viewVars($params);
					$email->send();
					
					return $this->redirect(array(
						'action' => 'thanks'
					));
				}
				else
				{
					$this->Flash->success(__('会員情報を変更致しました'));
				}
			}
			else
			{
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		else
		{
			$options = array(
					'conditions' => array(
							'Member.' . $this->Member->primaryKey => $id
					)
			);
			$this->request->data = $this->Member->find('first', $options);
		}

		$this->loadModel('Group');
		$this->loadModel('Nation');

		$groups  = $this->Group->find('list');
		$nations = $this->Nation->find('list');
		
		// 会員情報を取得
		$options = array(
			'conditions' => array(
				'Member.' . $this->Member->primaryKey => $id
			)
		);
		
		$member = $this->Member->find('first', $options);

		$this->set(compact('groups', 'nations', 'member'));
	}

	public function thanks()
	{
	}

	public function admin_add()
	{
		$this->admin_edit();
		$this->render('admin_edit');
	}

	// 検索対象のフィルタ設定
	/*
	 * public $filterArgs = array( array('name' => 'name', 'type' => 'value',
	 * 'field' => 'Member.name'), array('name' => 'name', 'type' => 'like',
	 * 'field' => 'Member.username'), array('name' => 'username', 'type' => 'like',
	 * 'field' => 'Content.title') );
	 */
	public function admin_index()
	{
		// 検索条件設定
		$this->Prg->commonProcess();

		$conditions = $this->Member->parseCriteria($this->Prg->parsedParams());

		$group_id	= (isset($this->request->query['group_id'])) ? $this->request->query['group_id'] : "";
		$username	= (isset($this->request->query['username'])) ? $this->request->query['username'] : "";
		$name		= (isset($this->request->query['name']))     ? $this->request->query['name'] : "";

		$conditions = array();

		if($username != "")
			$conditions['Member.username like'] = '%'.$username.'%';

		if($name != "")
			$conditions['Member.name like'] = '%'.$name.'%';

		$result = $this->paginate();

		$this->Group = new Group();
		$this->set('groups',   $this->Group->find('list'));
		$this->set('members', $result);
		$this->set('group_id', $group_id);
		$this->set('name',     $name);
	}

	public function admin_welcome()
	{}

	public function admin_edit($id = null)
	{
		if ($this->action == 'admin_edit' && ! $this->Member->exists($id))
		{
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			// 承認モード
			$is_approval_mode = false;
			
			if(
				(@$this->request->data['Member']['mode']=='is_apply')&&
				(@$this->request->data['Member']['status']=='1')
			)
			{
				$is_approval_mode = true;
			}


			if($is_approval_mode)
			{
				$this->request->data['Member']['password'] = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
			}
			else
			{
				if ($this->request->data['Member']['new_password'] !== '')
					$this->request->data['Member']['password'] = $this->request->data['Member']['new_password'];
			}

			if ($this->Member->save($this->request->data))
			{
				$this->Flash->success(__('会員情報が保存されました'));

				unset($this->request->data['Member']['new_password']);
				
				
				//debug($this->request->data['Member']['mode']);
				
				// 旧ステータスが申込中で、新しいステータスが承認の場合、承認完了メールを送信する
				if(
					($this->request->data['Member']['mode']=='is_apply')&&
					($this->request->data['Member']['status']=='1')
				)
				{
					$name		= $this->request->data['Member']['name'];
					$to			= $this->request->data['Member']['email'];
					$admin_from	= Configure :: read('admin_from');
					
					$params = array(
						'name'		=> $name,
						'username'	=> $this->request->data['Member']['username'],
						'password'	=> $this->request->data['Member']['password'],
					);
					
					// 申込者宛
					$email = new CakeEmail();
					$email->from($admin_from);
					$email->to($to);
					$email->subject('[OAMMS]承認完了メール');
					$email->template('approval');
					$email->viewVars($params);
					$email->send();
					$this->Flash->success(__('会員に承認完了メールが送信されました'));
				}

				return $this->redirect(array(
					'action' => 'index'
				));
			}
			else
			{
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		else
		{
			$options = array(
					'conditions' => array(
							'Member.' . $this->Member->primaryKey => $id
					)
			);
			$this->request->data = $this->Member->find('first', $options);
			
			//debug($this->request->data);
		}

		$this->Group  = new Group();
		//debug($this->Group);
		$this->loadModel('Nation');

		$groups  = $this->Group->find('list');
		$nations = $this->Nation->find('list');
		$this->set(compact('groups', 'nations'));
	}

	public function admin_setting()
	{
		if ($this->request->is(array(
				'post',
				'put'
		)))
		{
			//debug($this->request->data);
			$this->request->data['Member']['id'] = $this->Session->read('Auth.Member.id');

			if($this->request->data['Member']['new_password'] != $this->request->data['Member']['new_password2'])
			{
				$this->Flash->success(__('入力された「パスワード」と「パスワード（確認用）」が一致しません'));
				return;
			}

			if($this->request->data['Member']['new_password'] !== '')
			{
				$this->request->data['Member']['password'] = $this->request->data['Member']['new_password'];

				if ($this->Member->save($this->request->data))
				{
					$this->Flash->success(__('パスワードが保存されました'));
				}
				else
				{
					$this->Flash->error(__('The user could not be saved. Please, try again.'));
				}
			}
			else
			{
				$this->Flash->error(__('パスワードを入力して下さい'));
			}
		}
		else
		{
			$options = array(
				'conditions' => array(
						'Member.' . $this->Member->primaryKey => $this->Session->read('Auth.Member.id')
				)
			);
			$this->request->data = $this->Member->find('first', $options);
		}
	}

	public function admin_login()
	{
		$this->login();
	}

	public function admin_logout()
	{
		$this->logout();
	}
	
	public function mail()
	{
		$this->autoRender = FALSE;
		
		$name	= '山田太郎';
		$mail	= 'miura@irohasoft.jp';
		$admin_from	= Configure :: read('admin_mail.from');
		$admin_to	= Configure :: read('admin_mail.to');
		
		debug($admin_to);
		debug($admin_from);
		
		$params = array(
			'name' => $name,
		);
		
		// 申込者宛
		$email = new CakeEmail();
		$email->from($admin_from);
		$email->to($mail);
		$email->subject('[OAMMS]入会申込受付メール');
		$email->template('apply');
		$email->viewVars($params);
		$email->send();
		
		// 管理者宛
		$email = new CakeEmail();
		$email->from($admin_from);
		$email->to($admin_to);
		$email->subject('[OAMMS]入会申込通知メール');
		$email->template('admin_apply');
		$email->viewVars($params);
		$email->send();
	}
}
