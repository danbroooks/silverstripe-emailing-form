<?php

class EmailingForm extends Form {

	public $testing;
	protected $email;

	public function __construct($controller, $name, FieldList $fields, FieldList $actions, $validator = null) {
		parent::__construct($controller, $name, $fields, $actions, $validator);
		$this->email = Email::create();
		$this->testing = false;
	}

	public function Send($data = array()) {

		if ($this->testCondition($this->email, $data)) {
			$this->testing = true;
			$this->email->setTo(EmailTools::$testRouteAddress);
		}

		$this->email->populateTemplate(EmailTools::sanitize($data));

		try {
			$this->email->send();

		} catch (Exception $e) {
			SS_Log::log($e, SS_Log::ERR);

		}
	}

	public function setEmail($email) {
		$this->email = $email;
		return $this;
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

	public function attachFile($filename, $attachedFilename = null, $mimetype = null) {
		$this->email->attachFile($filename, $attachedFilename = null, $mimetype = null);
		return $this;
	}

	public function attachFileFromString($data, $filename, $mimetype = null) {
		$this->email->attachFileFromString($data, $filename, $mimetype = null);
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
