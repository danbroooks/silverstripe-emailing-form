<?php

class EmailTools {

	public static $testRouteAddress;
	public static $testAddresses = array();

	public static function setTestRouteAddress($address) {
		self::$testRouteAddress = $address;
	}

	public static function setTestAddresses($addresses) {
		self::$testAddresses = $addresses;
	}

	public static function addTestAddress($address) {
		array_push(self::$testAddresses, $address);
	}

	public static function isTestAddress($email) {
		return in_array($email, self::$testAddresses);
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