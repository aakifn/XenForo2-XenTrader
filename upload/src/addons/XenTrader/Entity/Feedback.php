<?php

namespace XenTrader\Entity;

use XF\Mvc\Entity\Structure;

class Feedback extends \XF\Mvc\Entity\Entity
{
	public static function getStructure(Structure $structure)
	{
		$structure->table = 'xf_xentrader_feedback';
		$structure->shortName = 'XenTrader:Feedback';
		$structure->primaryKey = 'feedback_id';
		$structure->columns = [
			'feedback_id' => ['type' => self::UINT, 'autoIncrement' => true],
			'from_user_id' => ['type' => self::UINT],
			'from_username' => ['type' => self::STR, 'maxLength' => 50, 'required' => 'please_enter_valid_name'],
			'to_user_id' => ['type' => self::UINT],
			'to_username' => ['type' => self::STR, 'maxLength' => 50, 'required' => 'please_enter_valid_name'],
			'thread_id' => ['type' => self::UINT, 'default' => '0'],
			'feedback' => ['type' => self::STR],
			'rating' => ['type' => self::STR, 'default' => 'neutral', 'allowedValues' => ['positive', 'neutral', 'negative']],
			'role' => ['type' => self::STR, 'default' => 'buyer', 'allowedValues' => ['buyer', 'seller', 'trader']],
			'feedback_date' => ['type' => self::UINT, 'default' => time()]
		];
		$structure->getters = [];
		$structure->relations = [
			'Thread' => [
				'entity' => 'XF:Thread',
				'type' => self::TO_ONE,
				'conditions' => 'thread_id'
			],
		];

		return $structure;
	}
}