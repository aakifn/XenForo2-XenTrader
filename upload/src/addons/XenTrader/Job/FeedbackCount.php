<?php

namespace XenTrader\Job;

class FeedbackCount extends \XF\Job\AbstractJob
{
	protected $defaultData = [
		'steps' => 0,
		'start' => 0,
		'batch' => 250
	];

	public function run($maxRunTime)
	{
		$start = microtime(true);

		$this->data['steps']++;

		$db = $this->app->db();

		$feedbackLeft = $db->fetchAll($db->limit(
			"
				SELECT *
				FROM xf_xentrader_feedback
				WHERE feedback_id > ?
				ORDER BY feedback_id
			", $this->data['batch']
		), $this->data['start']);
		if (!$feedbackLeft)
		{
			return $this->complete();
		}

		/** @var \XenTrader\Repository\Feedback $feedbackRepo */
		$feedbackRepo = $this->app->repository('XenTrader:Feedback');

		$done = 0;

		foreach ($feedbackLeft AS $feedback)
		{
			if (microtime(true) - $start >= $maxRunTime)
			{
				break;
			}

			$this->data['start'] = $feedback['feedback_id'];

			$positive = $feedbackRepo->getUserPositiveFeedbackCount($feedback['to_user_id']);
			$neutral = $feedbackRepo->getUserNeutralFeedbackCount($feedback['to_user_id']);
			$negative = $feedbackRepo->getUserNegativeFeedbackCount($feedback['to_user_id']);


			$db->update('xf_xentrader_user_feedback', [
				'positive' => $positive,
				'neutral' => $neutral,
				'negative' => $negative,
				'total' => $positive - $negative
			], 'user_id = ?', $feedback['to_user_id']);

			$done++;
		}

		$this->data['batch'] = $this->calculateOptimalBatch($this->data['batch'], $done, $start, $maxRunTime, 1000);

		return $this->resume();
	}

	public function getStatusMessage()
	{
		$actionPhrase = \XF::phrase('rebuilding');
		$typePhrase = \XF::phrase('xentrader_feedback_counts');
		return sprintf('%s... %s (%s)', $actionPhrase, $typePhrase, $this->data['start']);
	}

	public function canCancel()
	{
		return true;
	}

	public function canTriggerByChoice()
	{
		return true;
	}
}