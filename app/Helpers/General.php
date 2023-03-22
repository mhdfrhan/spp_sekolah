<?php

use App\Setting;

if (!function_exists('routecontroller')) {

	/**
	 * Pretty Route Controller
	 *
	 * @param
	 * @return
	 */
	function routecontroller($prefix, $controller)
	{
		$prefix = trim($prefix, '/') . '/';

		if (substr($controller, 0, 1) != "\\") {
			$controller = "\App\Http\Controllers\\" . $controller;
		}

		$exp = explode("\\", $controller);
		$controller_name = end($exp);

		try {
			Route::get($prefix, ['uses' => $controller . '@getIndex', 'as' => $controller_name . 'GetIndex']);

			$controller_class = new \ReflectionClass($controller);
			$controller_methods = $controller_class->getMethods(\ReflectionMethod::IS_PUBLIC);
			$wildcards = '/{one?}/{two?}/{three?}/{four?}/{five?}';
			foreach ($controller_methods as $method) {

				if ($method->class != 'Illuminate\Routing\Controller' && $method->name != 'getIndex') {
					if (substr($method->name, 0, 3) == 'get') {
						$method_name = substr($method->name, 3);
						$slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
						$slug = strtolower(implode('-', $slug));
						$slug = ($slug == 'index') ? '' : $slug;
						Route::get($prefix . $slug . $wildcards, ['uses' => $controller . '@' . $method->name, 'as' => $controller_name . 'Get' . $method_name]);
					} elseif (substr($method->name, 0, 4) == 'post') {
						$method_name = substr($method->name, 4);
						$slug = array_filter(preg_split('/(?=[A-Z])/', $method_name));
						Route::post($prefix . strtolower(implode('-', $slug)) . $wildcards, [
							'uses' => $controller . '@' . $method->name,
							'as' => $controller_name . 'Post' . $method_name,
						]);
					}
				}
			}
		} catch (\Exception $e) {
		}
	}
}

if (!function_exists('g')) {

	/**
	 * Pretty Route Controller
	 *
	 * @param
	 * @return
	 */
	function g($name)
	{
		return Request::get($name);
	}
}

if (!function_exists('setting')) {

	/**
	 * Get Content Setting
	 *
	 * @param
	 * @return
	 */
	function setting($slug)
	{
		$find = Setting::where('slug', $slug)->first();

		return $find->content;
	}
}

if (!function_exists('spp_month')) {

	/**
	 * Get Content Setting
	 *
	 * @param int
	 * @return string
	 */
	function spp_month($int)
	{
		$start_month = setting('month_begin');
		$start_index = ($start_month < 1 || $start_month > 12) ? 0 : $start_month - 1;
		$months = array(
			"Januari",
			"Februari",
			"Maret",
			"April",
			"Mei",
			"Juni",
			"Juli",
			"Agustus",
			"September",
			"Oktober",
			"November",
			"Desember"
		);
		$index = ($start_index + $int - 1) % 12;
		return $months[$index];
	}
}

