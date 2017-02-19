<?php

if (true && !function_exists('usernameIdentifier')) { // true to open the function

	/**
	 * Identify which field the username should be
	 *
	 * @param $username
	 * @return string
	 */
	function usernameIdentifier($username)
	{
		if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $username)) return 'chinese_name';
		if (filter_var($username, FILTER_VALIDATE_EMAIL)) return 'email';
		if (is_numeric($username)) return 'phone_number';

		return 'name';
	}
}
