<?php

class ImageController extends Controller {

    public $layout = '//layouts/main';
    public $user;
    public $ticker;

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

    public function actionIndex($order = 'recent') {
        $limit = 48;
        switch ($order) {
            case 'recent':
                $criteria = new CDbCriteria();
                $criteria->limit = $limit;
                $images = eImage::model()->with('user')->accepted()->isNotAvatar()->recent()->findAll($criteria);
                break;
            default:
                $images = eImage::model()->isNotAvatar()->getImagesOrderBy($order, $limit);
                break;
        }
        $this->render('index', array(
            'images' => $images,
                )
        );
    }

    public function actionView($view_key) {

        $image = eImage::model()->with('user')->accepted()->findByAttributes(array('view_key' => $view_key));
        $user = eUser::model()->findByPK($image->user_id);

        if (!Yii::app()->user->isGuest) {
            $imageView = new eImageView;
            $imageView->user_id = Yii::app()->user->getId();
            $imageView->image_id = $image->id;
            $imageView->save();
        }

        if (isset($_GET['fb_action_ids'])) {
                unset($_GET['fb_action_ids']);
            }
            if (isset($_GET['fb_action_types'])) {
                unset($_GET['fb_action_types']);
            }
            if (isset($_GET['fb_source'])) {
                unset($_GET['fb_source']);
            }
            if (isset($_GET['fb_aggregation_id'])) {
                unset($_GET['fb_aggregation_id']);
            }

        $this->render('view', array(
            'image' => $image,
            'user' => $user,
                )
        );
    }

    public function actionUpload() {

        if (Yii::app()->user->isGuest) {
            $this->redirect('/login');
        }

        $uploadimage = new FormImageUpload;
        //$user = new eUser;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'image-upload-form') {
            echo CActiveForm::validate(array($uploadimage));
            Yii::app()->end();
        }

        if (isset($_POST['FormImageUpload'])) {
            $uploadimage->attributes = $_POST['FormImageUpload'];
            $uploadimage->image = CUploadedFile::getInstance($uploadimage, 'image');

            if ($uploadimage->validate()) {

                $record = array();
                $user = Yii::app()->user->getId();
                preg_match('/\..{3,4}$/', $uploadimage->image->getName(), $matches);
                $filetype = $matches[0];
                $filename = "{$user}_" . uniqid('',true) . $filetype;
                $record['filename'] = $filename;

                $record['arbitrator_id'] = Yii::app()->user->getId();
                $record['user_id'] = Yii::app()->user->getId();
                $record['source'] = 'web';
                $record['title'] = $uploadimage->title;
                $record['description'] = $uploadimage->description;
                $record['is_avatar'] = 0;
                $record['view_key'] = eImage::generateViewKey();
                $record['status'] = 'new';

                $inserted = eImage::insertRecord($record);

                if(Yii::app()->params['image']['autoApprove']) {
                        $inserted->status = 'accepted';

                if(Yii::app()->params['image']['useExtendedFilters']) {
                        $inserted->extendedStatus['accepted'] = true;
                        $inserted->extendedStatus['new_tv'] = true;
                        }
                    } else {
                        $inserted->status = 'new';
                    }

                // see if user selected share to twitter or facebook
                if ($uploadimage->to_twitter == '1')
                    if (eUserTwitter::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0)//no connection to twitter
                        $inserted->to_twitter = 0;
                    else {
                        $inserted->to_twitter = 1;
                    }
                if ($uploadimage->to_facebook == '1')
                    if (eUserFacebook::model()->countByAttributes(array('user_id' => Yii::app()->user->id)) == 0)//no connection to facebook
                        $inserted->to_facebook = 0;
                    else {
                        $inserted->to_facebook = 1;
                    }

                      if (Yii::app()->Paypal->active) {
                    $paypal = PaymentUtility::paypal($uploadimage);
                    if ($paypal['response'] == 'success') {
                        $this->redirect($paypal['url']);
                    } else {
                        var_dump($paypal);
                        //$this->redirect(Yii::app()->createURL('/thanks'));
                    }
                }

                if ($inserted) {
                    $uploadimage->image->saveAs(Yii::app()->params['paths']['avatar'] . "/{$filename}");
                    $inserted->save();
                    $this->redirect('/image/thanks');
                } else {
                    Yii::app()->user->setFlash('error', Yii::app()->params['custom_params']['image_insertrecord_error']);
                }
            }
//            else {
//                Yii::app()->user->setFlash('error', Yii::app()->params['validation_error']);
//            }
        }
        $this->render('upload', array(
            'uploadimage' => $uploadimage,
        ));
    }

    public function actionThanks() {
        if (Yii::app()->user->isGuest) {
            $this->redirect('/login');
        }

        $this->render('thanks', array());
    }

    public function actionAjaxRate() {
        $this->layout = false;
        foreach ($_POST as $k => $v) {
            $$k = $v;
        }

        if (!Yii::app()->user->isGuest) {
            $imageRate = eImageRating::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'image_id' => $object_id));
            $imageRate = (is_null($imageRate)) ? new eImageRating() : $imageRate;
            $imageRate->user_id = Yii::app()->user->getId();
            $imageRate->image_id = $object_id;
            $imageRate->rating = $rating;
            $imageRate->save();
            $image = eImage::model()->findByPK($object_id);
            echo json_encode(array('avg' => $image->rating, 'votes' => sizeof($image->imageRatings)));
        }
    }

}