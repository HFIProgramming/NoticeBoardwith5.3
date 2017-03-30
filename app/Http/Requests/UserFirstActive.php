<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFirstActive extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => ['required', 'max:255', 'regex:/([A-Za-z])/', 'unique:users'],
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:8|confirmed',
			'english_name' => ['required', 'max:255', 'regex:/([A-Za-z])/'],
			// 'phone_number' => ['nullable', 'numeric', 'regex:^1(3[0-9]|4[57]|5[0-35-9]|7[0135678]|8[0-9])', 'unique:users'], // @TODO Something goes wrong here :(
			'wechat' => 'nullable|string|unique:users',
		];
	}

	/**
	 * name identify
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'name.regex' => __('request.at_least_one_character'),
		];
	}
}
