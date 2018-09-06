<?php

class clientUserController extends UserController {

    public $layout = '//layouts/main';
    public $user;

    function init() {
        parent::init();

        if (!Yii::app()->user->isGuest) {
            $this->user = ClientUtility::getUser();
        }
    }

    public function actionAjaxSetSessionBoolean() {
        foreach ($_POST as $k => $v) {
            $k = $v;
        }
        Yii::app()->session[$var] = 1;
    }

    public function actionProfile() {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect('/login');
        }
        $user_id = Yii::app()->user->getId();
        $user = eUser::model()->findByPK($user_id);
        $user->password = '';
        $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => $user->id, 'type' => 'primary'));
        $userEmail = (is_null($userEmail)) ? new eUserEmail : $userEmail;
        $userLocation = eUserLocation::model()->findByAttributes(array('user_id' => $user->id, 'type' => 'primary'));
        $userLocation = (is_null($userLocation)) ? new eUserLocation : $userLocation;

        $userPhone = eUserPhone::model()->findByAttributes(array('user_id' => $user_id, 'type' => 'primary'));
        if (is_null($userPhone)) {
            $userPhone = new eUserPhone;
        }
        $userPhone->setScenario('profile');

        $twitterUsername = 'twitter user';
        $userTwitter = eUserTwitter::model()->findByAttributes(array('user_id' => $user_id));
        if ($userTwitter) {
            $twitterUsername = TwitterUtility::getUsernameFromID($userTwitter->twitter_user_id);
        }

        $facebookUsername = 'facebook user';
        $userFacebook = eUserFacebook::model()->findByAttributes(array('user_id' => $user_id));
        if ($userFacebook) {
            $facebookUsername = FacebookUtility::getUsernameFromID($userFacebook->facebook_user_id);
        }

        $user->setScenario('profile');
        $userEmail->setScenario('profile');
        $userLocation->setScenario('profile');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-profile-form') {
            echo CActiveForm::validate(array($user, $userEmail, $userLocation));
            //echo CActiveForm::validate(array($user, $userEmail, $userLocation, $userPhone, $userTwitter, $userFacebook));
            Yii::app()->end();
        }

        if (isset($_POST['eUser'], $_POST['eUserEmail'], $_POST['eUserLocation'], $_POST['eUserPhone'])) {
            $user->attributes = $_POST['eUser'];
            if(!empty($_POST['eUser']['birthYear']) && !empty($_POST['eUser']['birthMonth']) && !empty($_POST['eUser']['birthDay']))
                $user->birthday = $_POST['eUser']['birthYear'] . '-' . $_POST['eUser']['birthMonth'] . '-' . $_POST['eUser']['birthDay'];
            //$user->username = $_POST['eUserEmail']['email'];
            $userEmail->attributes = $_POST['eUserEmail'];
            $userEmail->user_id = $user->id;
            $userLocation->attributes = $_POST['eUserLocation'];
            $userLocation->user_id = $user->id;
            $userPhone->attributes = $_POST['eUserPhone'];
            $userPhone->user_id = $user->id;
            $userPhone->type = 'primary'; // this client only supports 1 phone

            if ($user->validate() && $userEmail->validate() && $userLocation->validate() && $userPhone->validate()) {
                $user->save();
                $userEmail->save();
                $userLocation->save();
                $userPhone->save();

                // We don't Twitter->save() or Facebook->save() directly.
                // That is handled by the Connections page.

                Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['profileUpdateSuccess']);
            }
        }

        $this->render('profile', array(
            'user' => $user,
            'userEmail' => $userEmail,
            'userLocation' => $userLocation,
            'userPhone' => $userPhone,
            'twitterUsername' => $twitterUsername,
            'facebookUsername' => $facebookUsername,
        ));
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest) {
            //Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect(Yii::app()->createURL('site/index'));
        }
        $user = new eUser;
        $user->setScenario('login');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-login-form') {
            echo CActiveForm::validate($user);
            Yii::app()->end();
        }
        if (isset($_POST['eUser'])) {
            $user->attributes = $_POST['eUser'];
            if (UserUtility::login($user)) {
                $userRecord = $user->findByAttributes(array('username' => $user->username));
                AuditUtility::save($this, $_REQUEST);
                //Yii::app()->user->setFlash('success', SUCCESS_LOGIN . " {$userRecord->first_name}");
                $this->redirect(Yii::app()->user->returnUrl);
            } else {
                Yii::app()->user->setFlash('error', Yii::app()->params['flashMessage']['loginError']);
                $this->redirect('/login');
            }
        }

        $this->render('login', array('model' => $user));
    }

    public function actionRegister() {
        if (!Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
        }
        $user = new clientUser;
        $userEmail = new clientUserEmail;
        $userLocation = new eUserLocation;
        $user->setScenario('register');
        $userEmail->setScenario('register');
        $userLocation->setScenario('register');
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-register-form') {
            echo CActiveForm::validate(array($user, $userEmail, $userLocation));
            Yii::app()->end();
        }
        if (isset($_POST['clientUser'], $_POST['clientUserEmail'], $_POST['eUserLocation'])) {
            $user->attributes = $_POST['clientUser'];
            $userEmail->attributes = $_POST['clientUserEmail'];
            $userLocation->attributes = $_POST['eUserLocation'];
            $user->username = $userEmail->email;
            if (empty($user->birthday))
                $user->birthday = $user->birthYear . '-' . $user->birthMonth . '-' . $user->birthDay;
            $user->source = 'web';
            $userEmail->type = 'primary';
            $userEmail->active = 1;
            $userLocation->type = 'primary';
            if (UserUtility::register($user, $userEmail, $userLocation)) {
                MailUtility::send('welcome', $userEmail->email);
                Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['registrationSuccess']);
                $user->password = $_POST['clientUser']['password'];
                $user->setScenario('login');
                UserUtility::login($user);
                $this->redirect('/');
            }
        }
        $this->render('register', array(
            'user' => $user,
            'userEmail' => $userEmail,
            'userLocation' => $userLocation,
        ));
    }

    public function actionPassword() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('/user/login'));
        }

        $user_id = Yii::app()->user->getId();
        $user = clientUser::model()->findByPK($user_id);
        $user->setScenario('changePassword');

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-password-form') {
            echo CActiveForm::validate(array($user));
            Yii::app()->end();
        }

        if (isset($_POST[get_class($user)])) {
            $user->attributes = $_POST[get_class($user)];
            if ($user->validate()) {
                $user->password = $user->newPassword;
                if ($user->save()) {
                    Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['passwordUpdateSuccess']);
                }
            }
        }

        $this->render('password', array(
            'user' => $user,
        ));
    }

    public function actionForgot($key = false) {
        if (!$key) {
            $model = new eUser;
            $model->setScenario('reset');
            if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-login-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if (isset($_POST['eUser'])) {
                $model->attributes = $_POST['eUser'];
                if ($model->validate()) {
                    $userRecord = $model->findByAttributes(array('username' => $model->username));
                    $userEmail = eUserEmail::model()->findByAttributes(array('user_id' => $userRecord->id));
                    $reset = new eUserReset;
                    $reset->user_id = $userRecord->id;
                    $reset->key = sha1(uniqid());
                    $reset->expired = 0;
                    if ($reset->save()) {
                        $result = MailUtility::send('forgot password', $userEmail->email, array('link' => Yii::app()->createAbsoluteUrl("forgot/{$reset->key}", array())), false);
                        if ($result) {
                            Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['resetPasswordSuccess']);
                        } else {
                            Yii::app()->user->setFlash('error', Yii::app()->params['flashMessage']['resetPasswordError'] . " {$model->username}.");
                        }
                    } else {
                        Yii::app()->user->setFlash('error', Yii::app()->params['flashMessage']['resetPasswordError'] . " {$model->username}.");
                    }
                }
            }
            $this->render('forgot', array('model' => $model));
        } else {
            $reset = eUserReset::model()->active()->findByAttributes(array('key' => $key, 'expired' => 0));
            if (!empty($reset->user_id)) {
                $reset->expired = 1;
                $reset->save();
                $user = eUser::model()->findByPK($reset->user_id);
                $user->scenario = 'reset';
                if (UserUtility::login($user)) {
                    $this->redirect('/you/password');
                } else {
                    $this->redirect('/login');
                }
            } else {
                $this->redirect(Yii::app()->createUrl('/user/login'));
            }
        }
    }

    public function actionUserPhoto() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('/user/login'));
        }
        $user_id = Yii::app()->user->getId();
        $user = eUser::model()->findByPK($user_id);
        $image = new eImage;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-profileimage-form') {
            echo CActiveForm::validate(array($user, $image));
            Yii::app()->end();
        }

        if (isset($_POST['eImage'])) {
            if (isset($_POST['eUser']))
                $user->attributes = $_POST['eUser'];

            $image->attributes = $_POST['eImage'];
            $image->user_id = $user->id;
            $image->image = CUploadedFile::getInstance($image, 'image');
            $image->title = 'Avatar';
            $image->description = 'User avatar image.';
            $image->source = 'web';
            $image->to_facebook = 0;
            $image->to_twitter = 0;
            //$image->status = (Yii::app()->params['image']['autoApproveAvatar'] === true) ? 'accepted' : 'new'; //old
            //new
            if (Yii::app()->params['image']['autoApproveAvatar'] === true) {
                $image->status = 'accepted';
                if (Yii::app()->params['image']['useExtendedFilters'] === true) {
                    $image->extendedStatus['accepted'] = true;
                }
            } else {
                $image->status = 'new';
                if (Yii::app()->params['image']['useExtendedFilters'] === true) {
                    $image->extendedStatus['new'] = true;
                }
            }
            $image->arbitrator_id = $user->id;
            $image->is_avatar = 1;
            if ($image->validate()) {
                //eImage::model()->updateAll(array('is_avatar' => 0), 'user_id=' . $user->id);
                preg_match('/\..{3,4}$/', $image->image->getName(), $matches);
                $filetype = $matches[0];
                $image->filename = $filename = "{$user->id}_" . md5(uniqid('', true) . $image->filename) . $filetype;
                $image->image->saveAs(Yii::app()->params['paths']['avatar'] . "/{$filename}");
                if ($image->save())
                    Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['avatarUpdateSuccess']);
                else
                    Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['avatarUpdateError']);
            } else {
                Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['avatarUpdateError']);
            }
        }

        $this->render('userphoto', array(
            'user' => $user,
            'image' => $image,
                )
        );
    }

    public function actionPrivacy() {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->createUrl('/user/login'));
        } else {
            $user_id = Yii::app()->user->getId();
            $this->render('privacy', array(
                'user' => $this->user,
                    )
            );
        }
    }

    public function actionPrivacyOverlay() {
        $this->render('privacyOverlay', array());
    }

    public function actionTermsOverlay() {
        $this->render('termsOverlay', array());
    }

    public function actionImageView($order = 'recent') {

        $user_id = Yii::app()->user->getId();
        $user = eUser::model()->findByPK($user_id);
        if ($order == 'recent')
            $order = "t.id";
        $criteria = new CDbCriteria();
        $criteria->limit = 48;
        $criteria->select = '*, COUNT(imageViews.id) AS views, AVG(imageRatings.rating) as rating';
        $criteria->with = array('user', 'imageRatings', 'imageViews');
        $criteria->together = true;
        $criteria->condition = Yii::app()->params['image']['useExtendedFilters'] ? ("t.statusbit & " . Yii::app()->params['statusBit']['accepted'] . " AND (t.statusbit & " . Yii::app()->params['statusBit']['denied'] . ") = 0") : 'status="accepted"';
        $criteria->condition .= ' and t.user_id=' . $user_id;
        $criteria->group = 't.id';
        $criteria->order = $order . ' DESC';
        $images = eImage::model()->isNotAvatar()->findAll($criteria);
        $this->render('imageview', array(
            'images' => $images,
            'user' => $user,
                )
        );
    }

    public function actionVideo($id, $order = 'recent') {
        if (Yii::app()->user->getId() == $id) {
            $this->redirect(Yii::app()->createURL('/you'));
        }
        switch ($order) {
            case 'recent':
                $videos = eVideo::model()->with('user', 'brightcoves')->accepted()->recent()->findAllByAttributes(array('user_id' => $id));
                break;
            default:
                $video = new eVideo;
                $videos = $video->orderBy($id, $order);
                break;
        }
        $user = eUser::model()->findByPK($id);
        if (is_null($user)) {
            throw new CHttpException(404, 'The specified user cannot be found.');
        }
        $this->render('view', array(
            'user' => $user,
            'videos' => $videos,
                )
        );
    }

    public function actionImage($id, $order = 'recent') {
        if (Yii::app()->user->getId() == $id) {
            $this->redirect(Yii::app()->createURL('/you'));
        }
        switch ($order) {
            case 'recent':
                $images = eImage::model()->with('user')->accepted()->isNotAvatar()->recent()->findAllByAttributes(array('user_id' => $id));
                break;
            default:
                $image = new eImage;
                $images = $image->orderBy($id, $order);
                break;
        }
        $user = eUser::model()->findByPK($id);
        if (is_null($user)) {
            throw new CHttpException(404, 'The specified user cannot be found.');
        }
        $this->render('view', array(
            'user' => $user,
            'images' => $images,
                )
        );
    }

    public function actionPhoto() {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect(Yii::app()->createURL('user/login'));
        }
        $user_id = Yii::app()->user->getId();
        $user = eUser::model()->findByPK($user_id);
        $image = new eImage;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-profileimage-form') {
            echo CActiveForm::validate(array());
            Yii::app()->end();
        }

        if (isset($_POST['eImage'])) {
            if (!empty($_FILES['eImage']['name']['image'])) {
                $image->attributes = $_POST['eImage'];
                $image->user_id = $user->id;
                $image->image = CUploadedFile::getInstance($image, 'image');
                $image->title = 'Avatar';
                $image->description = 'User avatar image.';
                $image->source = 'web';
                $image->to_facebook = 0;
                $image->to_twitter = 0;
                //$image->status = (Yii::app()->params['image']['autoApproveAvatar']) ? 'accepted' : 'new';
                if (Yii::app()->params['image']['autoApproveAvatar'] === true) {
                    $image->status = 'accepted';
                    if (Yii::app()->params['image']['useExtendedFilters'] === true) {
                        $image->extendedStatus['accepted'] = true;
                    }
                } else {
                    $image->status = 'new';
                    if (Yii::app()->params['image']['useExtendedFilters'] === true) {
                        $image->extendedStatus['new'] = true;
                    }
                }
                $image->arbitrator_id = $user->id;
                $image->is_avatar = 1;
                if ($image->validate()) {
                    //eImage::model()->updateAll(array('is_avatar' => 0), 'user_id=' . $user->id);
                    preg_match('/\..{3,4}$/', $image->image->getName(), $matches);
                    $filetype = $matches[0];
                    $filename = "{$user->id}_" . uniqid('', true) . $filetype;
                    $image->image->saveAs(Yii::app()->params['paths']['avatar'] . "/{$filename}");
                    $image->filename = $filename;
                    $image->save();
                    Yii::app()->user->setFlash('success', Yii::app()->params['flashMessage']['avatarUpdateSuccess']);
                }
            }
        }

        $this->render('photo', array(
            'user' => $user,
            'image' => $image,
        ));
    }

    public function actionConnections() {
        if (Yii::app()->user->isGuest) {
            Yii::app()->user->setReturnUrl(Yii::app()->request->getUrl());
            $this->redirect(Yii::app()->createURL('user/login'));
        }
        $user_id = Yii::app()->user->getId();
        $user = eUser::model()->with('userFacebooks', 'userTwitters')->findByPK($user_id);
        if (isset($user->userFacebooks[0]->access_token) && $user->userFacebooks[0]->access_token) {
            Yii::app()->facebook->setAccessToken($user->userFacebooks[0]->access_token);
            $facebook = Yii::app()->facebook->api('/me');
        }
        if (isset($user->userTwitters[0]->oauth_token) && $user->userTwitters[0]->oauth_token) {
            $twitter = Yii::app()->twitter->getTwitterTokened($user->userTwitters[0]->oauth_token, $user->userTwitters[0]->oauth_token_secret);
            $twuser = $twitter->get("account/verify_credentials");
        }
        $this->render('connections', array(
            'user' => $user,
            'facebook' => isset($facebook) ? $facebook : false,
            'twuser' => isset($twuser) ? $twuser : false,
        ));
    }

    public function actionYoutooTerms() {
        $this->render('youtooterms', array());
    }

    public function actionYoutooPrivacy() {
        $this->render('youtooprivacy', array());
    }

    public function actionSettinglinks() {
        $this->render('settingLinks', array());
    }

}

?>
