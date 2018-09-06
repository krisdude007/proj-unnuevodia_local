<html>
<head>
<title>Connect</title>
</head>
<body>
<?php if($connected): ?>    
<script>
    window.close();
</script>
<?php else: ?>
<div class="signup" style="width:34%;height:275px;margin-right:auto;margin-left:auto;">
<?php
    $this->renderPartial('/user/_formTwitter',
        array(
            'user'=>$user,
            'access_token'=>$access_token,
            'userEmail'=>$userEmail,
            'userLocation'=>$userLocation,
            'twuser'=>$twuser,
        )
    );
?>
</div>
<?php endif; ?>
</body>
</html>