# Silverstripe emailing form

This module bundles the emailing process into a form object. It also lets you route emails to a test address for manual testing of an email form.

## Usage

Build the form as usual, but with `EmailingForm::create()` instead of `Form::create()`.
EmailingForm exposes setting up the email via the form object.


    public function ContactForm(

        // ...

        $form = EmailingForm::create(
            $this, 'ContactForm', $fields, $actions
        );

        $form->setTo('recipient@gmail.com');
        $form->setFrom('Me <sender@gmail.com>');
        $form->setSubject('Hello');
        $form->setEmailTemplate('ContactFormEmail');

        return $form;
    }


Then in the form action simply do:

    public function SendForm($data, $form){
        $form->Send($data);
    }

## Test conditions

This module can be configured to route test emails to a test address for manual form testing.
In your main project, configure the EmailTools object in your _config.php:

    EmailTools::setTestRouteAddress('emailtest@yourdomain.co.uk');
    EmailTools::setTestData(array('emailtest@yourdomain.co.uk'));


Then when you're setting up the form as shown in the usage example do:

    $form->setTestCondition(function($e, $data)
    {
        return EmailTools::isTestData($data['Email']);
    });

The module passes the submitted $data to this callback, if it is set.
In this example, we're checking the input data 'Email', however you can check any field you like.
If this callback returns true, EmailingForm will route your email to your test address.

