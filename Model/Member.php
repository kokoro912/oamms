<?php
/**
 * OAMMS Project
 *
 * @author        Kotaro Miura
 * @copyright     2016 Advanced Institute of Industrial Technology
 * @link          http://aiit.ac.jp/
 * @license       http://www.gnu.org/licenses/gpl-3.0.en.html GPL License
 */

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

/**
 * Member Model (学生)
 *
 * @property Group $Group
 * @property Content $Content
 * @property Event $Event
 * @property Group $Group
 */
class Member extends AppModel
{

	public $validate = array(
		'username' => array(
				array(
						'rule' => 'isUnique',
						'message' => 'ログインIDが重複しています'
				),
				array(
						'rule' => 'alphaNumeric',
						'message' => 'ログインIDは英数字で入力して下さい'
				),
				array(
						'rule' => array(
								'between',
								2,
								32
						),
						'message' => 'ログインIDは5文字以上32文字以内で入力して下さい'
				)
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'kana' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'gender' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'birthday' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'nation_id' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'zip' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'prefecture' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'address1' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'tel_no' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'email' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'send_type' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'subscription' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'password' => array(
				array(
						'rule' => 'alphaNumeric',
						'message' => 'パスワードは英数字で入力して下さい'
				),
				array(
						'rule' => array(
								'between',
								4,
								32
						),
						'message' => 'パスワードは4文字以上32文字以内で入力して下さい'
				)
		),
		'new_password' => array(
				array(
						'rule' => 'alphaNumeric',
						'message' => 'パスワードは英数字で入力して下さい',
						'allowEmpty' => true
				),
				array(
						'rule' => array(
								'between',
								4,
								32
						),
						'required' => false,
						'message' => 'パスワードは4文字以上32文字以内で入力して下さい',
						'allowEmpty' => true
				)
		)
	);

	// The Associations below have been created with all possible keys, those
	// that are not needed can be removed

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Group' => array(
				'className' => 'Group',
				'foreignKey' => 'group_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),
		'Nation' => array(
				'className' => 'Nation',
				'foreignKey' => 'nation_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
	);

	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
			'Group' => array(
					'className' => 'Group',
					'joinTable' => 'members_groups',
					'foreignKey' => 'member_id',
					'associationForeignKey' => 'group_id',
					'unique' => 'keepExisting',
					'conditions' => '',
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'finderQuery' => ''
	 		)
	);

	/*
	function checkCompare($valid_field1, $valid_field2)
	{
		$fieldname = key($valid_field1);

		if ($this->data[$this->name][$fieldname] === $this->data[$this->name][$valid_field2])
		{
			return true;
		}
		return false;
	}
	*/

	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password']))
		{
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		return true;
	}

	// 検索用
	public $actsAs = array(
			'Search.Searchable'
	);

	public $filterArgs = array(
			'username' => array(
					'type' => 'like',
					'field' => 'Member.name'
			),
			'active' => array(
					'type' => 'value'
			)
	);

}
