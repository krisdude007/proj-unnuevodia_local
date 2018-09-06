<?php
/* @var $this UserController */
?>
<div id="content">
    <div class="you">
        <?php
        $this->renderPartial('/user/_sidebar', array(
            'user' => $user,
        ));
        $this->renderPartial('/user/_profileHeader', array());
        ?>
        <div class="youContent">
            <div class="profile" style="width:580px">
                <?php
                $this->renderPartial('/user/_formProfile', array(
                    'user' => $user,
                    'userEmail' => $userEmail,
                    'userLocation' => $userLocation,
                    'userPhone' => $userPhone,
                    'twitterUsername' => $twitterUsername,
                    'facebookUsername' => $facebookUsername,
                ));
                ?>
            </div>
        </div>
    </div>
</div>
