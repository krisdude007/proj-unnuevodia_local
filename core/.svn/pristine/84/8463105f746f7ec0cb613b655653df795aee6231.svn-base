<?php 

class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $message;
	public $department;
	 
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name, email, subject, message', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('department', 'safe'),
			 
		);
	}

	 
}