<?php

namespace XenTrader\Pub\Controller;

class Trader extends \XF\Pub\Controller\AbstractController
{
	public function actionIndex()
	{
		$viewParams = [];

		return $this->view('XenTrader:View', 'xentrader_index', $viewParams);
	}
}