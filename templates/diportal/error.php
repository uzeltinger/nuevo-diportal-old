<?php

/**
 *
 * Error view
 *
 * @version             1.0.0
 * @package             Gavern Framework
 * @copyright			Copyright (C) 2010 - 2011 GavickPro. All rights reserved.
 *               
 */
 
// No direct access.
defined('_JEXEC') or die;
jimport('joomla.factory');
// get the URI instance
$uri = JURI::getInstance();

//echo JURI::current();
jimport( 'joomla.mail.mail' );
//jimport( 'joomla.utilities.utility' );
$jEmail = new JMail();

echo '<pre><b>';print_r($this->error);


// get the template params
$templateParams = JFactory::getApplication()->getTemplate(true)->params; 
// get the webmaster e-mail value
if($templateParams->get('webmaster_contact_type') != 'none') {     // get the webmaster e-mail value
     $webmaster_contact = $templateParams->get('webmaster_contact', '');
     if($templateParams->get('webmaster_contact_type') == 'email') {
          // e-mail cloak
          $searchEmail = '([\w\.\-]+\@(?:[a-z0-9\.\-]+\.)+(?:[a-z0-9\-]{2,4}))';
          $searchText = '([\x20-\x7f][^<>]+)';
          $pattern = '~(?:<a [\w "\'=\@\.\-]*href\s*=\s*"mailto:' . $searchEmail . '"[\w "\'=\@\.\-]*)>' . $searchText . '</a>~i';   
          preg_match($pattern, '<a href="mailto:'.$webmaster_contact.'">'.JText::_('TPL_GK_LANG_CONTACT_WEBMASTER').'</a>', $regs, PREG_OFFSET_CAPTURE);
          $replacement = JHtml::_('email.cloak', $regs[1][0], 1, $regs[2][0], 0);
          $webmaster_contact_email = substr_replace($webmaster_contact, $replacement, $regs[0][1], strlen($regs[0][0]));
     }
}

// get necessary template parameters
$templateParams = JFactory::getApplication()->getTemplate(true)->params;
$pageName = JFactory::getDocument()->getTitle();

// get logo configuration
$logo_type = $templateParams->get('logo_type');
$logo_image = $templateParams->get('logo_image');
$template_style = $templateParams->get('template_color');

if(($logo_image == '') || ($templateParams->get('logo_type') == 'css')) {
     $logo_image = JURI::base() . 'images/logo.jpg';
} else {
     $logo_image = JURI::base() . $logo_image;
}
$logo_text = $templateParams->get('logo_text', '');
$logo_slogan = $templateParams->get('logo_slogan', '');

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title><?php echo $this->error->getCode(); ?>-<?php echo $this->title; ?></title>
<link rel="stylesheet" href="<?php echo JURI::base(); ?>templates/<?php echo $this->template; ?>/css/system/error.style.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>
<div id="gkPage">
	<div id="left">
			<?php if ($logo_type !=='none'): ?>
			<?php if($logo_type == 'css') : ?>
			<a href="./" id="gkLogo" class="cssLogo"></a>
			<?php elseif($logo_type =='text') : ?>
			<a href="./" id="gkLogo text"> <span><?php echo $logo_text; ?></span> <small class="gkLogoSlogan"><?php echo $logo_slogan; ?></small> </a>
			<?php elseif($logo_type =='image') : ?>
			<a href="./" id="gkLogo"> <img src="<?php echo $logo_image; ?>" alt="<?php echo $pageName; ?>" /> </a>
			<?php endif; ?>
			<?php endif; ?>
	</div>
	<div id="right">
			<h2><?php echo $this->error->getCode(); ?></h2>
	</div>
	<p class="errorboxbody">
	<?php echo JText::_('TPL_GK_LANG_ERROR_INFO'); ?> <?php echo JText::_('TPL_GK_LANG_ERROR_DESC'); ?>
	</p>
	<p class="errorboxbody"><a href="<?php echo JURI::base(); ?>" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a> <span> | </span>
			<?php if($templateParams->get('webmaster_contact_type') == 'email') : echo $webmaster_contact_email; ?>
			 <?php elseif($templateParams->get('webmaster_contact_type') == 'url') : ?>
				  <a href="<?php echo $webmaster_contact; ?>"><?php  echo JText::_('TPL_GK_LANG_CONTACT_WEBMASTER'); ?></a>
			 <?php endif; ?>

	</p>
</div>
</body>
</html>

<?php

$userIP = getUserIP();

$bodyMail = '
de: '.$userIP.'
<br>
página: '.JURI::current().'
<br>
';

//echo $bodyMail;



	
	
	
function getUserIP() {
if (isset($_SERVER)) { if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
{ $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; }
elseif(isset($_SERVER["HTTP_CLIENT_IP"]))
{ $ip = $_SERVER["HTTP_CLIENT_IP"]; }
else { $ip = $_SERVER["REMOTE_ADDR"]; }
}
else { if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
{ $ip = getenv( 'HTTP_X_FORWARDED_FOR' ); }
elseif ( getenv( 'HTTP_CLIENT_IP' ) )
{ $ip = getenv( 'HTTP_CLIENT_IP' ); }
else { $ip = getenv( 'REMOTE_ADDR' ); }
}
return $ip;
}
?>