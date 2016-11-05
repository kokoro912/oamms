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

/**
 * MembersEvent Model
 *
 * @property Group $Group
 * @property Event $Event
 * @property User $User
 * @property Content $Content
 */
class MembersEvent extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
			'event_id' => array(
					'numeric' => array(
							'rule' => array(
									'numeric'
							)
					// 'message' => 'Your custom message here',
					// 'allowEmpty' => false,
					// 'required' => false,
					// 'last' => false, // Stop validation after this rule
					// 'on' => 'create', // Limit validation to 'create' or
					// 'update' operations
										)
			),
			'member_id' => array(
					'numeric' => array(
							'rule' => array(
									'numeric'
							)
					// 'message' => 'Your custom message here',
					// 'allowEmpty' => false,
					// 'required' => false,
					// 'last' => false, // Stop validation after this rule
					// 'on' => 'create', // Limit validation to 'create' or
					// 'update' operations
										)
			),
	);
	
	// The Associations below have been created with all possible keys, those
	// that are not needed can be removed
	public $hasMany = array(
	);

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
			'Event' => array(
					'className' => 'Event',
					'foreignKey' => 'event_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
			'Member' => array(
					'className' => 'Member',
					'foreignKey' => 'member_id',
					'conditions' => '',
					'fields' => '',
					'order' => ''
			),
	);
	
	public function getMemberEvent($member_id)
	{
		$sql = <<<EOF
 SELECT Event.*, ApplyCount.apply_count
   FROM  ib_events Event
   LEFT OUTER JOIN
		(SELECT event_id, COUNT(*) as apply_count
		   FROM ib_members_events
		  WHERE status = 1
		    AND member_id =:member_id
		  GROUP BY event_id) ApplyCount
     ON ApplyCount.event_id   = Event.id
  ORDER BY ApplyCount.apply_count DESC
EOF;
		$params = array(
			'member_id' => $member_id
		);

		$data = $this->query($sql, $params);

		return $data;
	}

	// 検索用
	public $actsAs = array(
			'Search.Searchable'
	);

	public $filterArgs = array(
		'username' => array(
			'type' => 'like',
			'field' => 'Member.username'
		),
		'name' => array(
			'type' => 'like',
			'field' => 'Member.name'
		)
	);
}
