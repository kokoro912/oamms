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
 * Event Model
 *
 * @property Group $Group
 * @property Content $Content
 * @property ContentsQuestion $ContentsQuestion
 * @property EventsMember $EventsMember
 * @property User $User
 */
class Event extends AppModel
{

	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array(
		'title' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'started' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			),
			'checkStarted' => array(
				'rule' => array('checkStarted'),
				'message' => 'dummy',
			),
		),
		'ended' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
		'opened' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			),
			'checkOpened' => array(
				'rule' => array('checkOpened'),
				'message' => 'dummy',
			),
		),
		'closed' => array(
			'notBlank' => array(
				'rule' => array(
						'notBlank'
				)
			)
		),
	);
	
	// The Associations below have been created with all possible keys, those
	// that are not needed can be removed
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
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
	);

	public function checkStarted($date1, $date2)
	{
		$date1 = $this->data['Event']['started'];
		$date2 = $this->data['Event']['ended'];
		
		return (strtotime($date1) <= strtotime($date2));
	}

	public function checkOpened($date1, $date2)
	{
		$date1 = $this->data['Event']['opened'];
		$date2 = $this->data['Event']['closed'];
		
		return (strtotime($date1) <= strtotime($date2));
	}
}
