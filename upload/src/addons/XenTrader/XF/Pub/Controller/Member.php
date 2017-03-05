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
			$visitor = \XF::visitor();

			$input = $this->filter([
				'role' => 'str',
				'rating' => 'str',
				'feedback' => 'str',
			]);

			$input['from_user_id'] = $visitor->user_id;
			$input['from_username'] = $visitor->username;
			$input['to_user_id'] = $user->user_id;
			$input['to_username'] = $user->username;

			/** @var \XenTrader\Entity\Feedback $entity */
			$entity = \XF::em()->create('XenTrader:Feedback');
			$entity->bulkSet($input);
			$entity->save();

			return $this->redirect($this->getDynamicRedirect());
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