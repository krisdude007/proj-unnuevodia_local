<?php

class SiteController extends Controller
{
    public $layout = '//layouts/main';
    public $user;
    public $ticker; // used for ticker form shown on every page when user is logged in

    /**
     * Anything required on every page should be loaded here
     * and should also be made a class member.
     */
    function init() {
        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
            $this->ticker = new eTicker();
        }
    }

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            $this->render('index');
	}


	public function actionAdvertise()
	{
	    $this->render('advertise');
	}

	public  function actionPress()
	{
	    $model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";
                $body = $model->message;
				mail(Yii::app()->params['press_email'],$subject,$body,$headers);
				Yii::app()->user->setFlash('success', Yii::t('youtoo','Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->redirect(Yii::app()->createURL('site/index'));
			}
		}
		$this->render('press',array('model'=>$model));

	}

	public function actionFaq()
	{
	    $this->render('faq');
	}


	public function actionContact()
    {
        $model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";
                $body = 'A user requires assistance on '.Yii::app()->name. "\r\n". $model->department."\r\n".$model->message;
				mail(Yii::app()->params['custom_params']['client_support_email'],$subject,$body,$headers);
				Yii::app()->user->setFlash('success',Yii::t('youtoo','Thank you for contacting us. We will respond to you as soon as possible.'));
				$this->redirect(Yii::app()->createURL('site/index'));
			}
		}
		$this->render('contact',array('model'=>$model));
    }


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}