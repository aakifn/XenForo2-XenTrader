<?php

namespace XenTrader\Stats;

use XF\Stats\AbstractHandler;

class Feedback extends AbstractHandler
{
	public function getStatsTypes()
	{
		return [
			'total_feedback' => \XF::phrase('xentrader_total_feedback'),
			'positive_feedback' => \XF::phrase('xentrader_positive_feedback'),
			'neutral_feedback' => \XF::phrase('xentrader_neutral_feedback'),
			'negative_feedback' => \XF::phrase('xentrader_negative_feedback')
		];
	}

	public function getData($start, $end)
	{
		$db = $this->db();

		$total = $db->fetchPairs(
			$this->getBasicDataQuery('xf_xentrader_feedback', 'feedback_date'),
			[$start, $end]
		);

		$positive = $db->fetchPairs(
			$this->getBasicDataQuery('xf_xentrader_feedback', 'feedback_date', 'rating = ?'),
			[$start, $end, 'positive']
		);

		$neutral = $db->fetchPairs(
			$this->getBasicDataQuery('xf_xentrader_feedback', 'feedback_date', 'rating = ?'),
			[$start, $end, 'neutral']
		);

		$negative = $db->fetchPairs(
			$this->getBasicDataQuery('xf_xentrader_feedback', 'feedback_date', 'rating = ?'),
			[$start, $end, 'negative']
		);

		return [
			'total_feedback' => $total,
			'positive_feedback' => $positive,
			'neutral_feedback' => $neutral,
			'negative_feedback' => $negative
		];
	}
}