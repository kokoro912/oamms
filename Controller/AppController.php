<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');
App::import('Vendor', 'Utils');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

	public $components = array(
			'DebugKit.Toolbar',
			'Session',
			'Flash',
			'Auth' => array(
					'loginRedirect' => array(
							'controller' => 'infos',
							'action' => 'index'
					),
					'logoutRedirect' => array(
							'controller' => 'users',
							'action' => 'login',
							'home'
					),
					'authError' => false
			)
	);
	
	//public $helpers = array('Session');
	public $helpers = array(
		'Session',
		'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
		'Form' => array('className' => 'BoostCake.BoostCakeForm'),
		'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
	);
	
	public $uses = array('Setting');
	
	public function beforeFilter()
	{
		$this->set('loginedUser', $this->Auth->user());
		
		// データベース内に格納された設定情報をセッションに格納
		if(!$this->Session->check('Setting'))
		{
			$settings = $this->Setting->getSettings();
			
			foreach ($settings as $key => $value)
			{
				$this->Session->Write('Setting.'.$key, $value);
			}
		}
		
		if (
			(isset($this->request->params['admin']))||
			($this->request->params['controller']=='admin')
		)
		{
			// roleがadmin以外の場合、強制ログアウトする
			if($this->Auth->user())
			{
				if($this->Auth->user('role')!='admin')
				{
					 $this->redirect($this->Auth->logout());
					return;
				}
			}
			
			$this->Auth->loginAction = array(
					'controller' => 'users',
					'action' => 'login',
					'admin' => true
			);
			$this->Auth->loginRedirect = array(
					'controller' => 'members',
					'action' => 'index',
					'admin' => true
			);
			$this->Auth->logoutRedirect = array(
					'controller' => 'users',
					'action' => 'login',
					'admin' => true
			);
			$this->set('loginURL', "/admin/users/login/");
			$this->set('logoutURL', "/admin/users/logout/");
			
			// グループ一覧を共通で保持する
			$this->loadModel('Group');
			$group_list = $this->Group->find('all');
			
			$this->set('group_list', 
					$this->Group->find('list', 
							array(
									'fields' => array(
											'id',
											'title'
									)
							)));
		}
		else
		{
			$this->Auth->loginAction = array(
					'controller' => 'members',
					'action' => 'login',
					'admin' => false
			);
			$this->Auth->loginRedirect = array(
					'controller' => 'members',
					'action' => 'index',
					'admin' => false
			);
			$this->Auth->logoutRedirect = array(
					'controller' => 'members',
					'action' => 'login',
					'admin' => false
			);
			
			$this->set('loginURL', "/members/login/");
			$this->set('logoutURL', "/members/logout/");
			
			if($this->Auth->user())
			{
				// roleがadminの場合、強制ログアウトする
				if($this->Auth->user('role')=='admin')
				{
					$this->redirect($this->Auth->logout());
					return;
				}
			}
			// $this->layout = 'login'; //レイアウトを切り替える。
			// AuthComponent::$sessionKey = "Auth.User";
		}
	}

	function writeLog($log_type, $log_content)
	{
		$data = array(
			'log_type'    => $log_type,
			'log_content' => $log_content,
			'user_id'     => $this->Session->read('Auth.User.id'),
			'user_ip'     => $_SERVER['REMOTE_ADDR'],
			'user_agent'  => $_SERVER['HTTP_USER_AGENT']
		);
		
		
		$this->loadModel('Log');
		$this->Log->create();
		$this->Log->save($data);
	}

}
