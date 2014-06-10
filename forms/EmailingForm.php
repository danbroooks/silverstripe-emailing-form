<?php

class EmailingForm extends Form {

	public $testing;
	protected $email;

	public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null) {
		parent::__construct($controller, $name, $fields, $actions, $validator);
		$this->email = new Email();
		$this->testing = false;
	}

	public function Send($data = array()) {

		if ($this->testCondition($this->email, $data)) {
			$this->testing = true;
			$this->email->setTo(EmailTools::$testRouteAddress);
		}

		$this->email->populateTemplate(EmailTools::sanitize($data));
		$this->email->send();
	}

	public function setTo($to) {
		$this->email->setTo($to);
		return $this;
	}

	public function setFrom($from) {
		$this->email->setFrom($from);
		$this->email->addCustomHeader('Reply-To', $from);
		return $this;
	}

	public function setSubject($subject) {
		$this->email->setSubject($subject);
		return $this;
	}

	public function setEmailTemplate($emailTemplate) {
		$this->email->setTemplate($emailTemplate);
		return $this;
	}

	public function testCondition($e, $data) {
		if (EmailTools::$testRouteAddress && $func = $this->testCondition) {
			return $func($e, $data);
		} else {
			return false;
		}
	}

	public function setTestCondition($func) {
		$this->testCondition = $func;
		return $this;
	}

}
