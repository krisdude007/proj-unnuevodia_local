<?php

define('SITE_NAME', 'UNNUEVODIA');
define('CLIENT_EMAIL_NAME','TELEMUNDO UNNUEVODIA ');

define('HTML_DIR','ltr');
define('HTML_LANG','es');

define('CLIENT_TZ', 'America/New_York');
define('CLIENT_XML_ENCODING', 'utf-16');

define('PAYPAL_ACTIVE', false);
define('PAYPAL_USERNAME', 'kyrie42-facilitator_api1.gmail.com');
define('PAYPAL_PASSWORD', '1364840459');
define('PAYPAL_SIGNATURE', 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAMim7FhqR5hEznOFh8CIior9BSdJ');
define('PAYPAL_API_LIVE', false);
define('PAYPAL_RETURN_URL', 'paypal/confirm/');
define('PAYPAL_CANCEL_URL', 'paypal/cancel/');

//This is YoutooSandbox app: http://dev.twitter.com/apps/5239419
//This is YoutooSandbox twitter page: http://www.twitter.com/YoutooSandbox
//define('TWITTER_ACTIVE',true);
//define('TWITTER_CONSUMER_KEY','RChO1lBGkJvQTZhOgjbw8A');
//define('TWITTER_CONSUMER_SECRET','NLD9sTbY1YLWz7SbvSNvQ80RTRBfoRGvAluYYJZy8');
//define('TWITTER_ADMIN_ACCESS_TOKEN','1967328594-hg0MWwc1GtYkdnfQUyOnrruBx3gDrzRCRWRpydB');
//define('TWITTER_ADMIN_TOKEN_SECRET','HnyF8uzVKxU1I6iR55iHOCjTtrCYOiasYXkMATPmE');
//define('TWITTER_ADVANCED_FILTERS', false);
// * THESE ARE UNNUEVODIA LIVE VALUES.  DO NOT ENABLE UNTIL GO LIVE!
define('TWITTER_ACTIVE', true);
define('TWITTER_CONSUMER_KEY', '6fNUrCW1PLdV71tepHv75A');
define('TWITTER_CONSUMER_SECRET', 'rVJAdP3AlkwRGS01Iku6BJ5gkGgTzFPDPKpsE3VYYE');
define('TWITTER_ADMIN_ACCESS_TOKEN', '41820310-dHGfn6n1HSw2wAsop13t7mOMgq4wGtfWEB3z6Q3lw');
define('TWITTER_ADMIN_TOKEN_SECRET', 'AXU4z2aTcoOBD9J47b0FC6ttkjuYSqw3pjLjB2z3dYhBj');

define('MODAL_COUNTRY_ADMIN',false);
/*
  //YoutooSandbox for dev
  define('FACEBOOK_ACTIVE',true);
  define('FACEBOOK_APPLICATION_NAMESPACE','youtoosandbox');
  define('FACEBOOK_APPLICATION_ID','177992429059463');
  define('FACEBOOK_APPLICATION_SECRET','ed3e68e1e14fd9d4069040276be986ed');
  define('FACEBOOK_PAGE_ID','569424999801446');
 *
 */

define('FACEBOOK_ACTIVE', true);
define('FACEBOOK_APPLICATION_NAMESPACE', 'unnuevodia_youtoo');
define('FACEBOOK_APPLICATION_ID', '661638177209195');
define('FACEBOOK_APPLICATION_SECRET', '3e8e6baf5d5c497a05cdf525d468a4b2');
define('FACEBOOK_PAGE_ID', '430827127022450');

/*
 * THESE ARE UNNUEVODIA LIVE VALUES.  DO NOT ENABLE UNTIL GO LIVE!
  define('FACEBOOK_PAGE_ID','35345841128');
 *
 */

define('BRIGHTCOVE_PLAYER_ID', '2929404779001');
define('BRIGHTCOVE_PLAYER_KEY', 'AQ~~,AAABqrGtIvE~,QfeoOVnmCtU2RJSnX8vs_7c53vsvAF2X');

/*
 * THESE ARE UNNUEVODIA LIVE VALUES.  DO NOT ENABLE UNTIL GO LIVE!
  define('BRIGHTCOVE_PLAYER_ID','2929404779001');
  define('BRIGHTCOVE_PLAYER_KEY','AQ~~,AAABqrGtIvE~,QfeoOVnmCtU2RJSnX8vs_7c53vsvAF2X');
 *
 */

define('MAX_ACTIVE_QUESTIONS', 3);

define('SET_FLASH',true);

//define('FTP_SECURE', false);
//define('FTP_PASSIVE', true);
//define('FTP_PORT', 21);
//define('FTP_SERVER', 'ftp.comstarmedia.com');
//define('FTP_USER', 'youtootech1');
//define('FTP_PASSWORD', 'Youtoot3ch#');
//define('FTP_PATH', '/CAMIO');


define('FTP_SECURE', false);
define('FTP_PASSIVE', true);
define('FTP_PORT', 33002);
define('FTP_SERVER', '54.85.41.170');
define('FTP_USER', 'telemundo_ftp');
define('FTP_PASSWORD', '2REZki2M6Qv7AZCWFVToP2igPYmVV9BmXzxXFh38prNo7NCn8p');
define('FTP_PATH', '');

define('VIDEO_POST_MOVFILE_ONLY',true);
define('FTP_XML',true);
define('FTP_XML_IMAGE',true);

define('SESSION_DURATION', 86400);

// video related
define('VIDEO_DURATION', 20);
define('VIDEO_FRAMES_PER_SEC', 30);
define('VIDEO_WATERMARK', '/webassets/images/watermark.png');
define('VIDEO_WATERMARK_LOCATION', 'topRight');
define('VIDEO_PARAMS', '-q:v 1 -async 1  -r 30 -b:v 2M -bt 4M -vcodec libx264 -preset placebo -g 1 -s 1920:1080 -s 1920x1080 -movflags +faststart -acodec libfdk_aac -ac 2 -ar 48000 -ab 192k -bufsize 10k');

define('VIDEO_UPLOAD_FILE_TYPE','mov,m4v,mp4');
define('VIDEO_UPLOAD_FILE_SIZE',1024 * 1024 * 30);

// sending video to client
// new, tested works fine, replace when Mark is ready (mjpeg to libx264)
//define('VIDEO_TO_TV_FFMPEG_PARAMS', ' -i {FILE_INPUT} -vcodec libx264 -preset placebo -bufsize 5000 -g 1 -acodec libfdk_aac -ac 2 -ar 48000 -ab 192k -r 30000/1001 -s 1920:1080 {FILE_OUTPUT} -y');
define('VIDEO_TO_TV_FFMPEG_PARAMS', ' -y -i {FILE_INPUT} -s 1920:1080 -vcodec mjpeg -b 20M -s 1920x1080 -r 30000/1001 -acodec pcm_s16le -ar 48000 -y -b:v 10k -bufsize 10k {FILE_OUTPUT}');

// custom ftp video filename
define('VIDEO_TO_TV_FILE_HAS_CUSTOM_FORMAT', true);
define('VIDEO_TO_TV_FILE_MUST_EVAL', false);
define('VIDEO_TO_TV_FILE_FORMAT_PREFIX', 'UND' . date('m') . date('d'));
define('VIDEO_TO_TV_FILE_FORMAT', '{INCREMENTED_VALUE}');
define('VIDEO_TO_TV_FILE_FORMAT_SUFFIX', '.mov');

// custom ftp image filename
define('IMAGE_TO_TV_FILE_HAS_CUSTOM_FORMAT', true);
define('IMAGE_TO_TV_FILE_MUST_EVAL', false);
define('IMAGE_TO_TV_FILE_FORMAT_PREFIX', 'UND' . date('m') . date('d'));
define('IMAGE_TO_TV_FILE_FORMAT', '{INCREMENTED_VALUE}');

define('IMAGE_TO_VIDEO', true);
//define('IMAGE_SCALE', ' -i {FILE_INPUT} -vf scale="\'if(gt(a,9/16),1920,-1)\':\'if(gt(a,9/16),-1,1080)\'" {FILE_OUTPUT} -y'); //this works too
define('IMAGE_SCALE', ' -i {FILE_INPUT} -vf "scale=iw*min(1920/iw\,1080/ih):ih*min(1920/iw\,1080/ih), pad=1920:1080:(1920-iw*min(1920/iw\,1080/ih))/2:(1080-ih*min(1920/iw\,1080/ih))/2" {FILE_OUTPUT} -y');
define('IMAGE_TO_VIDEO_FFMPEG_PARAMS', ' -loop 1 -f image2 -r 29.97 -i {FILE_INPUT} -vcodec libx264 -t 00:00:01 {FILE_OUTPUT} -y');
define('IMAGE_VIDEO_WAUDIO_FFMPEG_PARAMS', ' -i {FILE_INPUT_AUDIO} -i {FILE_INPUT} -map 0:0 -map 1:0 {FILE_OUTPUT} -shortest -y');
define('IMAGE_VIDEO_TO_TV_FFMPEG_PARAMS', ' -i {FILE_INPUT} -vcodec libx264 -preset placebo -bufsize 5000 -g 1 -acodec libfdk_aac -ac 2 -ar 48000 -ab 192k -r 30000/1001 {FILE_OUTPUT} -y');

// THIS FLAG WILL ALLOW US TO SWITCH BETWEEN
// NATIVE YTT FUNCTIONALITY SUCH AS SPOT FILLER
define('ENABLE_YOUTOO_FUNCTIONALITY', false);

define('CLIENT_SUPPORT_EMAIL', 'youtootechsupport@youtootech.com');

define('TICKER_SLEEP_TIME', 10);
define('TICKER_DEFAULT_QUESTION', 0);
define('TICKER_BREAKING', false);

define('QUESTION_T_DEFAULT_HASHTAG', '');
define('QUESTION_V_DEFAULT_HASHTAG', '');
define('T_QUESTION_DEFAULT_END_TIME', time() + 60 * 60 * 24 * 365 * 10); // 10 years
define('V_QUESTION_DEFAULT_END_TIME', time() + 365 * 60 * 60 * 24); // 1 year

// whether or not to auto approve avatars and/or images when they are uploaded
define('IMAGE_AUTO_APPROVE_AVATAR', false);
define('IMAGE_AUTO_APPROVE', false);

//Status Values Bit
define('STATUS_NEW_I', 128);
define('STATUS_ACCEPTED_I', 64);
define('STATUS_DENIED_I', 32);

define('STATUS_NEW_TV_I', 16);
define('STATUS_ACCEPTED_TV_I', 8);
define('STATUS_DENIED_TV_I', 4);

define('STATUS_ACCEPTED_SUP1_I', 2);
define('STATUS_ACCEPTED_SUP2_I', 1);

define('LOCATION_LAT', '37.09024');
define('LOCATION_LNG', '-95.712891');

// analytics
define('ANALYTICS_PROJECT_ID', '72166659');
define('ANALYTICS_START_DATE', '2013-11-14');

//Admin User extended permissions
define("USER_PERMISSIONS_EXTENDED", serialize(array("new" => "Producer Web",
    "newtv" => "Producer TV")));
//admin video page flags
define('VIDEO_FILTERS_EXTENDED', true);
define("VIDEO_FILTERS_EXTENDED_LABELS", serialize(array(array('new' => 'New Web', 'accepted' => 'Accepted Web'),
    array('newtv' => 'New TV', 'acceptedtv' => 'Accepted TV'))));

define("VIDEO_FILTERS_EXTENDED_SUPADMIN_LABELS", serialize(array('denied' => 'Denied Web', 'deniedtv' => 'Denied TV', 'all' => 'All')));

define('ADMIN_VIDEO_IMPORT', false);
define('ADMIN_VIDEO_IMPORT_VINE', false);
define('ADMIN_VIDEO_IMPORT_INSTAGRAM', false);
define('ADMIN_VIDEO_IMPORT_KEEK', false);
define('ADMIN_VIDEO_UPLOAD', false);
define('ADMIN_VIDEO_UPLOAD_AD', false);
define('ADMIN_VIDEO_AMPLIFY', false);

//added this flag as amplify tab is showing up in every tab in video modal window. Temporarily disabled this until discussed.
define('ADMIN_VIDEO_AMPLIFY_TAB', false);

//Added for zee to hide image data in premium reports, can be toggled
define('ADMIN_IMAGE_REPORT_TOGGLE', false);

//admin ticker page flags
define('TICKER_FILTERS_EXTENDED', true);
define("TICKER_FILTERS_EXTENDED_LABELS", serialize(array(array('new' => 'New Web', 'accepted' => 'Accepted Web'),
    array('newtv' => 'New TV', 'acceptedtv' => 'Accepted TV'))));

define("TICKER_FILTERS_EXTENDED_SUPADMIN_LABELS", serialize(array('denied' => 'Denied Web', 'deniedtv' => 'Denied TV')));

define('ADMIN_TICKER_ENTITY', false);

define('ADMIN_USER_MANUAL', true);
define('TWITTER_TAG', false);
define('TICKER_ICON', 'images/icons/shareImage.png');

define('REPORT_TWITTER_AMPLIFY', false);

//admin image page flags
define('IMAGE_FILTERS_EXTENDED', true);
define("IMAGE_FILTERS_EXTENDED_LABELS", serialize(array(array('new' => 'New Web', 'accepted' => 'Accepted Web'),
    array('newtv' => 'New TV', 'acceptedtv' => 'Accepted TV'))));

define("IMAGE_FILTERS_EXTENDED_SUPADMIN_LABELS", serialize(array('denied' => 'Denied Web', 'deniedtv' => 'Denied TV', 'all' => 'All')));

//setFlash constants for custom language

define('SUCCESS_LOGIN', 'Hola,', true);
define('PROFILE_UPDATE_SUCCESS', 'Perfil de usuario actualizada.', true);
define('AVATAR_SUCCESS', 'Imagen de perfil del usuario actualizada.', true);
define('AVATAR_ERROR','No se puede actualizar Avatar',true);
define('PWD_UPDATE_SUCCESS', 'Tu contraseña ha sido exitosamente actualizada', true);
define('REGISTER_SUCCESS', 'Has registrado correctamente. Revise su correo electrónico para recibir la confirmación', true);
define('ERROR_LOGIN', 'Nombre de usuario o contraseña no válidos.', true);
define('ERROR_TICKER_NOT_ADDED', 'No se puede añadir ticker!', true);
define('ERROR_TICKER_ADDED', 'Ticker añadido!', true);
define('ERROR_TICKER_SAVED', 'Ticker ahorrado!', true);
define('ERROR_TICKER_NOT_SAVED', 'Incapaz de salvar ticker', true);
define('ERROR_RESET_EMAIL_SENT', '<h2>Gracias por enviar una solicitud</h2>Un correo electrónico será enviado en breve con las instrucciones sobre cómo restablecer su contraseña.', true);
define('ERROR_RESET_EMAIL_NOT_SENT', 'No se pudo enviar un mensaje de restablecimiento de', true);
define('PHOTO_UPLOAD_SUCCESS', 'Foto subido correctamente.', true);
define('ERROR_TICKER_NOT_ACTIVE','Ticker is not active',true);

define('ERROR_INVALID_FILETYPE','Tipo de archivo no válido',true);

//Client feture toggle DO NOT DELETE ONLY COMMENT OUT PLEASE
define("CLIENT_FEATURES", serialize(array("HAS_VIDEO",
    "HAS_IMAGE",
    "HAS_USER",
    "HAS_AUDIT",
    "HAS_DAILY_REPORT",
    "HAS_QUESTION_REPORT",
    "HAS_REPORT",
    "HAS_LANGUAGE",
    "HAS_SOCIALSEARCH",
    //"HAS_SOCIALSTREAM",
    "HAS_QUESTION_VIDEO",
    "HAS_QUESTION_TICKER",
    "HAS_VOTING",
    "HAS_TICKER",
    "HAS_CONTACT",
    //"HAS_ENTITY",
    "HAS_TRAINING")));

define("CLIENT_DEFAULT_PAGINATION_COUNT", 50);

// auto ftp video
define('VIDEO_AUTO_FTP_BASED_ON_STATUS', false);
// auto ftp video / status to search for
define('VIDEO_AUTO_FTP_STATUS_FLAG', '');

define('CONTACT_SHOW_EMAIL_ASSISTANCE_LINK', false);


define('showTickerFormLogin', true);
// image related
define('IMAGE_UPLOAD_FILE_TYPE','gif,png,jpg');
define('IMAGE_UPLOAD_FILE_SIZE',1024 * 1024 * 5);