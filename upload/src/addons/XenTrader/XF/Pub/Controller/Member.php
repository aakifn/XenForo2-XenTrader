<?php

namespace XenTrader\XF\Pub\Controller;

use XF\Mvc\ParameterBag;

class Member extends XFCP_Member
{
	public function actionGiveFeedback(ParameterBag $params)
	{
		$user = $this->assertViewableUser($params->user_id);

		if ($this->isPost())
		{
			// todo: save feedback
		}
		else
		{
			$viewParams = [
				'user' => $user
			];

			return $this->view('XenTrader:Member\GiveFeedback', 'xentrader_give_feedback', $viewParams);
		}
	}
}

// ******************** FOR IDE AUTO COMPLETE ********************
if (false)
{
	class XFCP_Member extends \XF\Pub\Controller\Member {}
}