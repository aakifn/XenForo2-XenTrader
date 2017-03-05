<?php

namespace XenTrader\Repository;

use XF\Mvc\Entity\Finder;
use XF\Mvc\Entity\Repository;


class Feedback extends Repository
{
	public function getUserPositiveFeedbackCount($userId)
	{
		if ($userId instanceof \XF\Entity\User)
		{
			$userId = $userId->user_id;
		}

		return $this->db()->fetchOne("
			SELECT COUNT(*)
			FROM xf_xentrader_feedback
			WHERE to_user_id = ?
				AND rating = 'positive'
		", $userId);
	}

	public function getUserNeutralFeedbackCount($userId)
	{
		if ($userId instanceof \XF\Entity\User)
		{
			$userId = $userId->user_id;
		}

		return $this->db()->fetchOne("
			SELECT COUNT(*)
			FROM xf_xentrader_feedback
			WHERE to_user_id = ?
				AND rating = 'neutral'
		", $userId);
	}

	public function getUserNegativeFeedbackCount($userId)
	{
		if ($userId instanceof \XF\Entity\User)
		{
			$userId = $userId->user_id;
		}

		return $this->db()->fetchOne("
			SELECT COUNT(*)
			FROM xf_xentrader_feedback
			WHERE to_user_id = ?
				AND rating = 'neutral'
		", $userId);
	}
}