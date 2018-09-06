<?php
/* @var $this UserController */
/* @var $user clientUser */
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
            <div class="profile">
                <?php
                $this->renderPartial('/user/_formPassword', array(
                    'user' => $user,
                ));
                ?>
            </div>
        </div>
    </div>
</div>
