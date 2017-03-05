<?php

namespace XenTrader;

use XF\Mvc\Entity\Entity;

class Listener
{
	public static function userEntityStructure(\XF\Mvc\Entity\Manager $em, \XF\Mvc\Entity\Structure &$structure)
	{
		$structure->relations['Feedback'] = [
			'entity' => 'XenTrader:UserFeedback',
			'type' => \XF\Mvc\Entity\Entity::TO_ONE,
			'conditions' => [
				['user_id', '=', '$user_id']
			]
		];
	}
}