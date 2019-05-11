<?php 
/*
 *	Made by Samerton
 *  http://worldscapemc.co.uk
 *
 *  License: MIT
 */
 
/*
 *  Create code for page footer
 */

// Ensure the social media icons variable is set
if(!isset($social_media_icons)){
	$social_media_icons = '';
}

// Generate code for footer navigation
$footer_nav = '
<ul class="nav nav-pills dropup">';

if(isset($page_loading) && $page_loading == '1'){
	$footer_nav .= '
    <li><a data-toggle="tooltip" id="page_load_tooltip" title="Page loading.."><i class="fa fa-tachometer fa-fw"></i></a></li>';
}

if(isset($footer_nav_array)){
	foreach($footer_nav_array as $key => $item){
		$footer_nav .= '<li><a href="/' . $key . '">' . $item . '</a></li>';
	}
}

// Custom pages
$custom_pages = $queries->getWhere('custom_pages', array('url', '<>', ''));
foreach($custom_pages as $item){
	if($item->link_location == 3){
		$footer_nav .= '<li><a href="' . htmlspecialchars($item->url) . '">' . (isset($item->icon) ? $item->icon . ' ' : '') . htmlspecialchars($item->title) . '</a></li>';
	}
}

$footer_nav .= '
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">&copy; ' . htmlspecialchars($sitename) . ' ' . date('Y') . '</a>
		<ul class="dropdown-menu">
			<li><a href="#" target="_blank">Site software &copy; Samerton</a></li>
			<li><a href="https://github.com/NamelessMC/Nameless" target="_blank">Source available on GitHub.</a></li>
		</ul>
	</li>
	';

$footer_nav .= '</ul>';

$smarty->assign('SOCIAL_MEDIA_ICONS', $social_media_icons);
$smarty->assign('FOOTER_NAVIGATION', $footer_nav);

// Start: DisWeb

// Default settings
$server = "0";
$channel = "0";
$shard = "https://disweb.deploys.io";

// Query DB
$settings = $queries->getAll('disweb_settings', array("server", "<>", "0")); // Don't ask me why I have to add those params, it won't work without
if(!empty($settings)) {
    $row = $settings[0];
    $server = htmlspecialchars($row->server);
    $channel = htmlspecialchars($row->channel);
    $shard = htmlspecialchars($row->shard);
}

echo "<script src='https://cdn.jsdelivr.net/npm/@widgetbot/crate@3' async defer>
  new Crate({
    server: '" . $server . "',
    channel: '" . $channel . "',
    shard: '" . $shard . "'
  })
</script>";