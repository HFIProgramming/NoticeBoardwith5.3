<?php

if (!function_exists('CleanContent') && true) {

	/**
	 * description
	 *
	 * @param
	 * @return
	 */
	function CleanContent($content)
	{
		$antiXss = new \voku\helper\AntiXSS();
		return $antiXss->xss_clean($content,array('HTML.Allowed' => ''));
	}
}
