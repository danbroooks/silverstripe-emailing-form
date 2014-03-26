<?php

class EmailTools {

	public static $testRouteAddress;
	public static $testData = array();

	public static function setTestRouteAddress($address) {
		self::$testRouteAddress = $address;
	}

	public static function setTestData($data) {
		self::$testData = $data;
	}

	public static function addTestData($data) {
		array_push(self::$testData, $data);
	}

	public static function isTestData($data) {
		return in_array($data, self::$testData);
	}

	public static function sanitize($val) {
		if (is_array($val)) {
			foreach($val as $k => $v) $val[$k] = self::sanitize($v);
			return $val;
		} else {
			$val = self::normalizeWhitespace($val);
			return str_replace(array('&','<','>',"\n",'"',"'"), array('&amp;','&lt;','&gt;','<br />','&quot;','&#39;'), $val);
		}
	}

	private static function normalizeWhitespace($val) {
		return str_replace("\r\n", "\n", $val);
	}

}
