<?php

if (true && !function_exists('randomString')) {  // true to open the helper


	/**
	 *
	 * Generate random chars
	 *
	 * @param $length
	 * @param string $prefix
	 * @param bool $lowerCase
	 * @param bool $upperCase
	 * @param bool $number
	 * @param bool $specialChars
	 * @return string
	 */
	function randomString($length, $prefix = '', $lowerCase = true, $upperCase = true, $number = true, $specialChars = false)
	{
		$chars = '';
		$result = $prefix;
		if ($lowerCase) {
			$chars = 'abcdefghijklmnopqrstuvwxyz';
		}
		if ($upperCase) {
			$chars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if ($number) {
			$chars .= '0123456789';
		}
		if ($specialChars) {
			$chars .= '!@#$%^&*()';
		}
		$max = strlen($chars) - 1;
		for ($i = 0; $i < $length; $i++) {
			$result .= $chars[rand(0, $max)];
		}

		return $result;
	}
}
