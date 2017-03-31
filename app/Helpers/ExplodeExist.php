<?php

if (!function_exists('explodeExist') && true) {

	/**
	 * Find if exist
	 *
	 * @param $data
	 * @param $target
	 * @return bool
	 */
	function explodeExist($data, $target)
	{
		if ($data == NULL) return false;
		$collect = collect(explode("|", $data));
		return $collect->flatten()->search($target) !== false;
	}
}
