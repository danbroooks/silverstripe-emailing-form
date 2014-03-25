<?php

class EmailingForm extends Form {

	public $testing = false;

	protected $to;
	protected $from;
	protected $subject;
	protected $emailTemplate;

	public function Send($data) {

		$e = new Email();

		if ($this->testCondition($e, $data)) {
			$this->testing = true;
			$e->setTo(EmailTools::$testRouteAddress);
		} else {
			$e->setTo($this->to);
		}

		$data = EmailTools::sanitize($data);

		$e->setFrom($this->from);
		$e->addCustomHeader('Reply-To', $this->from);
		$e->setSubject($this->subject);
		$e->setTemplate($this->emailTemplate);
		$e->populateTemplate($data);
		$e->send();
	}

	public function setTo($to) {
		$this->to = $to;
	}

	public function setFrom($from) {
		$this->from = $from;
	}

	public function setSubject($subject) {
		$this->subject = $subject;
	}

	public function setEmailTemplate($emailTemplate) {
		$this->emailTemplate = $emailTemplate;
	}

	public function testCondition($e, $data) {
		if (EmailTools::$testRouteAddress && $func = $this->testCondition) {
			return $func($e, $data);
		} else {
			return false;
		}
	}

	public function setTestCondition($func){
		$this->testCondition = $func;
	}
}