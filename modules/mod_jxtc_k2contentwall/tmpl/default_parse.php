<?php

/*
	JoomlaXTC K2 Content Wall

	version 1.25.3

	Copyright (C) 2008-2012 Monev Software LLC.	All Rights Reserved.

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

	THIS LICENSE IS NOT EXTENSIVE TO ACCOMPANYING FILES UNLESS NOTED.

	See COPYRIGHT.txt for more information.
	See LICENSE.txt for more information.

	Monev Software LLC
	www.joomlaxtc.com
*/

defined( '_JEXEC' ) or die;

jimport( 'joomla.html.parameter' );


if ($enablerl) {
	require_once JPATH_ROOT.'/administrator/components/com_jxtcreadinglist/helper.php';
	$readinglist = jxtcrlHelper::getPluginButton($item,'com_k2');
} else $readinglist = '';

require_once (JPATH_SITE.'/components/com_k2/models/item.php');

// Article image
$ini = Jstring::strpos(strtolower($item->introtext), '<img');
if ($ini === false)
    $img = '';
else {
    $pos = Jstring::strpos($item->introtext, 'src="', $ini) + 5;
    $fin = Jstring::strpos($item->introtext, '"', $pos);
    $img = Jstring::substr($item->introtext, $pos, $fin - $pos);
    $fin = Jstring::strpos($item->introtext, '>', $fin);
}

$ini = Jstring::strpos(strtolower($item->fulltext), '<img');
if ($ini === false)
    $fullimg = '';
else {
    $pos = Jstring::strpos($item->fulltext, 'src="', $ini) + 5;
    $fin = Jstring::strpos($item->fulltext, '"', $pos);
    $fullimg = Jstring::substr($item->fulltext, $pos, $fin - $pos);
    $fin = Jstring::strpos($item->fulltext, '>', $fin);
}

$intronoimage = $item->introtext;
while (($ini = Jstring::strpos($intronoimage, '<img')) !== false) {
    if (($fin = Jstring::strpos($intronoimage, '>', $ini)) === false) {
        break;
    }
    $intronoimage = Jstring::substr_replace($intronoimage, '', $ini, $fin - $ini + 1);
}

$fullnoimage = $item->fulltext;
while (($ini = Jstring::strpos($fullnoimage, '<img')) !== false) {
    if (($fin = Jstring::strpos($fullnoimage, '>', $ini)) === false) {
        break;
    }
    $fullnoimage = Jstring::substr_replace($fullnoimage, '', $ini, $fin - $ini + 1);
}

$title = ($rowmaxtitle) ? Jstring::substr(strip_tags($item->title), 0, $rowmaxtitle) . $rowmaxtitlesuf : strip_tags($item->title);

$intro = ($rowmaxintro) ? Jstring::substr(strip_tags($item->introtext), 0, $rowmaxintro) . $rowmaxintrosuf : strip_tags($item->introtext);

$rawfulltext = $item->fulltext;
$fulltext = strip_tags($item->fulltext);
if (!empty($rowtextbrk)) {
    $pos = Jstring::strpos($rawfulltext, $rowtextbrk);
    if ($pos !== false) {
        $rawfulltext = substr($rawfulltext, 0, $pos + strlen($rowtextbrk));
    }
    $pos = Jstring::strpos($fulltext, $rowtextbrk);
    if ($pos !== false) {
        $fulltext = Jstring::substr($fulltext, 0, $pos + strlen($rowtextbrk));
    }
}

if (!empty($rowmaxtext)) {
    $fulltext = Jstring::trim(Jstring::substr($fulltext, 0, $rowmaxtext)) . $rowmaxtextsuf;
    $rawfulltext = Jstring::trim(Jstring::substr($rawfulltext, 0, $rowmaxtext)) . $rowmaxtextsuf;
}
$avatarw = $params->get('avatarw');
$avatarh = $params->get('avatarh');
$userid = $item->created_by;
$avatarimg = '';
$authorlink = '';
$articlelink = JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->catslug));
$categorylink = JRoute::_(K2HelperRoute::getCategoryRoute($item->catslug));

switch ($params->get('compat', 'none')) {
  case 'none':
      break;
  case 'cb':
      $db->setQuery("SELECT avatar from #__comprofiler WHERE user_id = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? '' : "<img src=\"" . $live_site . "components/com_comprofiler/images/$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_comprofiler' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_($live_site . 'index.php?option=com_comprofiler&view=profile&userid=' . $userid . $itemid);
      break;
  case 'jomsoc':
      $db->setQuery("SELECT avatar from #__community_users WHERE userid = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? "<img src=\".$live_site.components/com_community/assets/default.jpg\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />" : "<img src=\"$live_site$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_community' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_($live_site . 'index.php?option=com_community&view=profile&userid=' . $userid . $itemid);
      break;
  case 'ido':
      $db->setQuery("SELECT avatar from #__idoblog_users WHERE iduser = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? '' : "<img src=\"" . $live_site . "images/idoblog/$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_idoblog' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_($live_site . 'index.php?option=com_idoblog&task=profile&userid=' . $userid . $itemid);
      break;
  case 'myblog':
      require_once( JPATH_ROOT.'/components/com_myblog/modules/mod_myblog.php' );
      $objModule = new MyblogModule();
      $avatarimg = $objModule->_getAvatar($userid);
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_idoblog' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_("index.php?option=com_myblog&blogger=" . urlencode($item->author) . "&Itemid=" . $objModule->myGetItemId());
      $articlelink = myGetPermalinkUrl($item->id);
      $categorylink = JRoute::_('index.php?option=com_myblog&task=tag&category=' . $item->catid . '&Itemid=' . $objModule->myGetItemId());
      break;
  case 'fb':
      $db->setQuery("SELECT avatar from #__fb_users WHERE userid = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? '' : "<img src=\"" . $live_site . "images/fbfiles/avatars/$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_fireboard' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_($live_site . 'index.php?option=com_fireboard&func=fbprofile&task=showprf&userid=' . $userid . $itemid);
      break;
  case 'kunea':
      $db->setQuery("SELECT avatar from #__fb_users WHERE userid = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? "<img src=\"" . $live_site . "images/fbfiles/avatars/nophoto.jpg\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />" : "<img src=\"" . $live_site . "images/fbfiles/avatars/$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_kunena' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_($live_site . 'index.php?option=com_kunena&func=fbprofile&userid=' . $userid . $itemid);
      break;
  case 'k2':
      $db->setQuery("SELECT image from #__k2_users WHERE userID = '$userid'");
      $avatar = $db->loadResult();
      $avatarimg = empty($avatar) ? "<img src=\"" . $live_site . "components/com_k2/images/placeholder/user.png\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />" : "<img src=\"" . $live_site . "media/k2/users/$avatar\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
      $db->setQuery("SELECT id from #__components WHERE link = 'option=com_k2' and enabled='1'");
      $itemid = $db->loadResult();
      if ($itemid) {
          $itemid = '&Itemid=' . $itemid;
      }
      $authorlink = JRoute::_(K2HelperRoute::getUserRoute($userid));
      break;
	case 'komento':
		if (!class_exists("KomentoProfile")) {
			require_once( JPATH_ROOT.'/components/com_komento/bootstrap.php' );
			require_once( KOMENTO_CLASSES.'/profile.php' );
		}
		$komento_user = new KomentoProfile($userid);
		$avatarimg = "<img src=\"".$komento_user->getAvatar()."\" border=\"0\" width=\"$avatarw\" height=\"$avatarh\" />";
		$authorlink = $komento_user->getProfileLink();
	break;
}

$comments = 0;
switch ($params->get('comcompat', 'none')) {
  case 'none':
      break;
  case 'jomcom':
      $db->setQuery("SELECT count(*) from #__jomcomment WHERE contentid = '$item->id'");
      $comments = (int) $db->loadResult();
      break;
  case 'k2':
      $db->setQuery("SELECT count(*) from #__k2_comments WHERE itemID = '$item->id'");
      $comments = (int) $db->loadResult();
      break;
	case 'komento':
		$db->setQuery("SELECT count(*) from #__komento_comments WHERE component = 'com_k2' AND cid = $item->id AND published=1");
		$comments = (int) $db->loadResult();
	break;
}

//Image
$imageXSmallurl = '';
$imageSmallurl = '';
$imageMediumurl = '';
$imageLargeurl = '';
$imageXLargeurl = '';
$imageGenericurl = '';
$imageOriginalurl = '';

$imageXSmall = '';
$imageSmall = '';
$imageMedium = '';
$imageLarge = '';
$imageXLarge = '';
$imageGeneric = '';
$imageOriginal = '';

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_XS.jpg')) {
    $imageXSmallurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_XS.jpg';
    $imageXSmall = "<img src=" . $imageXSmallurl . " alt=" . $imageXSmallurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_S.jpg')) {
    $imageSmallurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_S.jpg';
    $imageSmall = "<img src=" . $imageSmallurl . " alt=" . $imageSmallurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_M.jpg')) {
    $imageMediumurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_M.jpg';
    $imageMedium = "<img src=" . $imageMediumurl . " alt=" . $imageMediumurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_L.jpg')) {
    $imageLargeurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_L.jpg';
    $imageLarge = "<img src=" . $imageLargeurl . " alt=" . $imageLargeurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_XL.jpg')) {
    $imageXLargeurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_XL.jpg';
    $imageXLarge = "<img src=" . $imageXLargeurl . " alt=" . $imageXLargeurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/cache/'.md5("Image" . $item->id) . '_Generic.jpg')) {
    $imageGenericurl = $live_site . 'media/k2/items/cache/' . md5("Image" . $item->id) . '_Generic.jpg';
    $imageGeneric = "<img src=" . $imageGenericurl . " alt=" . $imageGenericurl . " />";
}

if (JFile::exists(JPATH_SITE.'/media/k2/items/src/'.md5("Image" . $item->id) . '.jpg')) {
    $imageOriginalurl = $live_site . 'media/k2/items/src/' . md5("Image" . $item->id) . '.jpg';
    $imageOriginal = "<img src=" . $imageOriginalurl . " alt=" . $imageOriginalurl . " />";
}


$itemhtml = str_replace('{imageXSmall}', $imageXSmall, $itemhtml);
$itemhtml = str_replace('{imageSmall}', $imageSmall, $itemhtml);
$itemhtml = str_replace('{imageMedium}', $imageMedium, $itemhtml);
$itemhtml = str_replace('{imageLarge}', $imageLarge, $itemhtml);
$itemhtml = str_replace('{imageXLarge}', $imageXLarge, $itemhtml);
$itemhtml = str_replace('{imageGeneric}', $imageGeneric, $itemhtml);
$itemhtml = str_replace('{imageOriginal}', $imageOriginal, $itemhtml);

$itemhtml = str_replace('{imageXSmallurl}', $imageXSmallurl, $itemhtml);
$itemhtml = str_replace('{imageSmallurl}', $imageSmallurl, $itemhtml);
$itemhtml = str_replace('{imageMediumurl}', $imageMediumurl, $itemhtml);
$itemhtml = str_replace('{imageLargeurl}', $imageLargeurl, $itemhtml);
$itemhtml = str_replace('{imageXLargeurl}', $imageXLargeurl, $itemhtml);
$itemhtml = str_replace('{imageGenericurl}', $imageGenericurl, $itemhtml);
$itemhtml = str_replace('{imageOriginalurl}', $imageOriginalurl, $itemhtml);

if ($item->video) {
    if (JString::substr($item->video, 0, 1) !== '{') {
        $item->videoType = 'embedded';
    } else {
        $k2params = JComponentHelper::getParams('com_k2');
				$itemparams = new JRegistry;
				$itemparams->loadString($item->params);
        JPluginHelper::importPlugin('content', 'jw_allvideos');

        $dispatcher = JDispatcher::getInstance();

        $item->videoType = 'allvideos';
        $k2params->set('afolder', 'media/k2/audio');
        $k2params->set('vfolder', 'media/k2/videos');

        if (JString::strpos($item->video, 'remote}')) {
            preg_match("#}(.*?){/#s", $item->video, $matches);
            if (JString::substr($matches[1], 0, 7) != 'http://')
                $item->video = str_replace($matches[1], JURI::root() . $matches[1], $item->video);
        }

				$videow = $params->get('videow',0);
				$videoh = $params->get('videoh',0);
				$videoWidth = $videow ? $videow : $itemparams->get('itemVideoWidth');
				$videoHeight = $videoh ? $videoh : $itemparams->get('itemVideoHeight');
				
        $k2params->set('vwidth', $videoWidth);
        $k2params->set('vheight', $videoHeight);
        $k2params->set('autoplay', $itemparams->get('itemVideoAutoPlay'));

        $item->text = $item->video;
        
        $dispatcher->trigger('onContentPrepare', array('com_content.article', &$item, &$k2params, 0));
        
        $item->video = $item->text;
    }
}
$itemhtml = str_replace('{video}', $item->video, $itemhtml);

if ($item->gallery) {
    $k2params = JComponentHelper::getParams('com_k2');
    JPluginHelper::importPlugin('content', 'jw_sigpro');
    //JPluginHelper::importPlugin('content', 'jw_sig');

    /*if (JFile::exists(JPATH_ROOT.'/plugins/content/jw_simpleImageGallery/jw_simpleImageGallery.php'))
        JPlugin::loadLanguage('plg_content_jw_sig', JPATH_ROOT.'/administrator');
    
    if (JFile::exists(JPATH_ROOT.'/plugins/content/jw_sigpro/jw_sigpro.php'))
        JPlugin::loadLanguage('plg_content_jw_sigpro', JPATH_ROOT.'/administrator');*/

    $dispatcher = JDispatcher::getInstance();
    $k2params->set('galleries_rootfolder', 'media/k2/galleries');
    $k2params->set('thb_width', '150');
    $k2params->set('thb_height', '120');
    $k2params->set('popup_engine', 'mootools_slimbox');
    $k2params->set('enabledownload', '0');
    $item->text = $item->gallery;
    
    $dispatcher->trigger('onContentPrepare', array('com_content.article', &$item, &$k2params, 0));
    
    $item->gallery = $item->text;
}
$itemhtml = str_replace('{imagegallery}', $item->gallery, $itemhtml);

// Custom fields:
if (strpos($itemhtml, '{field_') !== false) { // Grab custom fields only when needed
    require_once('components/com_k2/helpers/utilities.php');

    $model = new K2ModelItem;
    $item->extra_fields = $model->getItemExtraFields($item->extra_fields);

    while (($ini = strpos($itemhtml, "{field_")) !== false) {
        $fin = strpos($itemhtml, "}", $ini);
        $filter = substr($itemhtml, $ini + 1, $fin - $ini - 1);
        @list($filter, $length) = explode(' ', $filter);
        $subfilter = trim(substr($filter, 6));
        $length = isset($length) ? trim($length) : 0;
        $value = '';
        foreach ($item->extra_fields as $val) {
            if ((string) $val->name == $subfilter) {
                $value = $val->value;
                if ($length && strlen($value) > $length) {
                    $value = substr($value, 0, $length);
                }
            }
        }
        $itemhtml = substr_replace($itemhtml, $value, $ini, $fin - $ini + 1);
    }
}

// Tags
if (strpos($itemhtml, '{tag') !== false) {
    $model = new K2ModelItem;
    $tags = $model->getItemTags($item->id);
    $tagslink = '';
    $tagsname = '';
    if (count($tags)) {
        for ($i = 0; $i < (sizeof($tags) - 1); $i++) {
            $tags[$i]->link = urldecode(JRoute::_(K2HelperRoute::getTagRoute($tags[$i]->name)));
            $tagsname .= $tags[$i]->name . ', ';
            $tagslink .= '<a href="' . $tags[$i]->link . '">' . $tags[$i]->name . '</a>, ';
        }
        $tags[$i]->link = urldecode(JRoute::_(K2HelperRoute::getTagRoute($tags[$i]->name)));
        $tagsname .= $tags[$i]->name;
        $tagslink .= '<a href="' . $tags[$i]->link . '">' . $tags[$i]->name . '</a>';
    }

    $itemhtml = str_replace('{tagnames}', $tagsname, $itemhtml);
    $itemhtml = str_replace('{taglinks}', $tagslink, $itemhtml);
}

//Related items
if (strpos($itemhtml, '{related') !== false) {
    $relatedname = '';
    $relatedlink = '';
    if (count($tags)) {
        require_once (JPATH_SITE.'/components/com_k2/helpers/utilities.php');
        require_once (JPATH_SITE.'/components/com_k2/models/itemlist.php');
        $model = new K2ModelItemlist;
        $relatedItems = $model->getRelatedItems($item->id, $tags, $related);

        if (count($relatedItems)) {
            for ($i = 0; $i < (sizeof($relatedItems) - 1); $i++) {
                $relatedItems[$i]->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($relatedItems[$i]->id . ':' . urlencode($relatedItems[$i]->alias), $relatedItems[$i]->catid . ':' . urlencode($relatedItems[$i]->categoryalias))));
                $relatedname .= $relatedItems[$i]->title . ', ';
                $relatedlink .= '<a href="' . $relatedItems[$i]->link . '">' . $relatedItems[$i]->title . '</a>, ';
            }
            $relatedItems[$i]->link = urldecode(JRoute::_(K2HelperRoute::getItemRoute($relatedItems[$i]->id . ':' . urlencode($relatedItems[$i]->alias), $relatedItems[$i]->catid . ':' . urlencode($relatedItems[$i]->categoryalias))));
            $relatedname .= $relatedItems[$i]->title;
            $relatedlink .= '<a href="' . $relatedItems[$i]->link . '">' . $relatedItems[$i]->title . '</a>';
        }
    }

    $itemhtml = str_replace('{relatedname}', $relatedname, $itemhtml);
    $itemhtml = str_replace('{relatedlink}', $relatedlink, $itemhtml);
}

//Twitter link
if (strpos($itemhtml, 'twitter') !== false) {
    $twitterURL = '';
    $cattwitterURL = '';
    $k2params = JComponentHelper::getParams('com_k2');

    if ($k2params->get('twitterUsername')) {
        // Absolute URL
        $uri = $live_site . $categorylink;
        //$uri = JURI::getInstance();
        //$itemURLForTwitter = ($k2params->get('tinyURL')) ? @file_get_contents('http://tinyurl.com/api-create.php?url='.$uri->_uri) : $uri->_uri;
        $itemURLForTwitter = ($k2params->get('tinyURL')) ? @file_get_contents('http://tinyurl.com/api-create.php?url=' . $uri) : $uri;
        $cattwitterURL = 'http://twitter.com/home/?status=' . urlencode('Reading @' . $k2params->get('twitterUsername') . ' ' . $item->cat_title . ' ' . $itemURLForTwitter);
    }

    if ($k2params->get('twitterUsername')) {
        // Absolute URL
        $uri = $live_site . $articlelink;
        //$uri = JURI::getInstance();
        //$itemURLForTwitter = ($k2params->get('tinyURL')) ? @file_get_contents('http://tinyurl.com/api-create.php?url='.$uri->_uri) : $uri->_uri;
        $itemURLForTwitter = ($k2params->get('tinyURL')) ? @file_get_contents('http://tinyurl.com/api-create.php?url=' . $uri) : $uri;
        $twitterURL = 'http://twitter.com/home/?status=' . urlencode('Reading @' . $k2params->get('twitterUsername') . ' ' . $title . ' ' . $itemURLForTwitter);
    }

    $itemhtml = str_replace('{itemtwitterurl}', $twitterURL, $itemhtml);
    $itemhtml = str_replace('{categorytwitterurl}', $cattwitterURL, $itemhtml);

    $twitter = '<span class="itemTwitterLink">
    <a title="' . JText::_('Like this? Tweet it to your followers!') . '" href="' . $twitterURL . '" target="_blank">' . JText::_($twetttext) . '</a></span>';

    $cattwitter = '<span class="itemTwitterLink">
    <a title="' . JText::_('Like this? Tweet it to your followers!') . '" href="' . $cattwitterURL . '" target="_blank">' . JText::_($cattwetttext) . '</a></span>';

    $itemhtml = str_replace('{itemtwitterlink}', $twitter, $itemhtml);
    $itemhtml = str_replace('{categorytwitterlink}', $cattwitter, $itemhtml);
}

//attachment
$attachment = '';
$attachmentname = '';
$attachmenthits = '';
$attachmentattrib = '';
$attachmentdownload = '';
$attachmenturl = '';


if (strpos($itemhtml, '{attach') !== false) { // Grab custom attachment only when needed
    $db->setQuery('SELECT * FROM #__k2_attachments AS a WHERE a.itemID = ' . $item->id);
    $temp = $db->loadObjectList();

    if ($temp) {
        if (is_array($temp)) {
            foreach ($temp as $aux) {
                $attachmenturl .= $live_site . 'index.php?option=com_k2&view=item&task=download&id=' . $aux->id . '<br>';
                $aux1 = $live_site . 'index.php?option=com_k2&view=item&task=download&id=' . $aux->id;
                $attachment .= $live_site . 'media/k2/attachments/' . $aux->filename . '<br>';
                $attachmentname .= $aux->title . '<br>';
                $aux2 = $aux->title;
                $attachmenthits .= $aux->hits . '<br>';
                $attachmentattrib .= $aux->titleAttribute . '<br>';
                $attachmentdownload .= '<a href="' . $aux1 . '">' . $aux2 . '</a>' . '<br>';
            }
        } else {
            $attachmenturl = $live_site . 'index.php?option=com_k2&view=item&task=download&id=' . $temp->id;
            $attachment = $live_site . 'media/k2/attachments/' . $temp->filename;
            $attachmentname = $temp->title;
            $attachmenthits = $temp->hits;
            $attachmentattrib = $temp->titleAttribute;
            $attachmentdownload = '<a href="' . $attachmenturl . '">' . $attachmentname . '</a>';
        }
    }
}

$categoryimageurl = 'No picture';
$categoryimage = 'No picture';
if ($item->cat_image) {
    $categoryimageurl = $live_site . 'media/k2/categories/' . $item->cat_image;
    $categoryimage = "<img src=" . $categoryimageurl . " alt=" . $categoryimageurl . " />";
}


$ratingprom = 0;
settype($item->rating_sum,'integer');
settype($item->rating_count,'integer');
if ($item->rating_count) {
    $ratingprom = ($item->rating_sum / $item->rating_count) * 20;
}

$rate = '<div class="itemRatingBlock"><div class="itemRatingForm">
    <ul class="itemRatingList">
            <li class="itemCurrentRating" id="itemCurrentRating' . $item->id . '" style="width:' . $ratingprom . '%;"></li>
            <li><a href="#" rel="' . $item->id . '" title="' . JText::_('1 star out of 5') . '" class="one-star">1</a></li>
            <li><a href="#" rel="' . $item->id . '" title="' . JText::_('2 stars out of 5') . '" class="two-stars">2</a></li>
            <li><a href="#" rel="' . $item->id . '" title="' . JText::_('3 stars out of 5') . '" class="three-stars">3</a></li>
            <li><a href="#" rel="' . $item->id . '" title="' . JText::_('4 stars out of 5') . '" class="four-stars">4</a></li>
            <li><a href="#" rel="' . $item->id . '" title="' . JText::_('5 stars out of 5') . '" class="five-stars">5</a></li>
    </ul>';
if ($numvotes)
    $rate .= '<div id="itemRatingLog' . $item->id . '" class="itemRatingLog">' . $item->rating_count . '</div><div class="clr"></div>';

$rate .= '</div><div class="clr"></div></div>';

$rating = '<div class="itemRatingBlock"><div class="itemRatingForm">
    <ul class="itemRatingList">
            <li class="itemCurrentRating" id="itemCurrentRating' . $item->id . '" style="width:' . $ratingprom . '%;"></li>
    </ul>';
if ($numvotes)
    $rating .= '<div id="itemRatingLog' . $item->id . '" class="itemRatingLog">' . $item->rating_count . '</div><div class="clr"></div>';

$rating .= '</div><div class="clr"></div></div>';

if (!$item->rating_sum) {
    $item->rating_sum = 'Not rated yet';
}
if (!$item->rating_count) {
    $item->rating_count = 'Not rated yet';
}
if (!$item->lastip) {
    $item->lastip = 'Not rated yet';
}

$itemhtml = str_replace('{ratingsum}', $item->rating_sum, $itemhtml);
$itemhtml = str_replace('{ratingcount}', $item->rating_count, $itemhtml);
$itemhtml = str_replace('{lastip}', $item->lastip, $itemhtml);
$itemhtml = str_replace('{rate}', $rate, $itemhtml);
$itemhtml = str_replace('{rating}', $rating, $itemhtml);

$itemhtml = str_replace('{attachmenturl}', $attachmenturl, $itemhtml);
$itemhtml = str_replace('{attachmentdownload}', $attachmentdownload, $itemhtml);
$itemhtml = str_replace('{attachment}', $attachment, $itemhtml);
$itemhtml = str_replace('{attachmentname}', $attachmentname, $itemhtml);
$itemhtml = str_replace('{attachmenthits}', $attachmenthits, $itemhtml);
$itemhtml = str_replace('{attachmentattrib}', $attachmentattrib, $itemhtml);

$itemhtml = str_replace('{id}', $item->id, $itemhtml);
$itemhtml = str_replace('{link}', $articlelink, $itemhtml);
$itemhtml = str_replace('{title}', $title, $itemhtml);
$itemhtml = str_replace('{intro}', $item->introtext, $itemhtml);
$itemhtml = str_replace('{intronoimage}', $intronoimage, $itemhtml);
$itemhtml = str_replace('{fullnoimage}', $fullnoimage, $itemhtml);
$itemhtml = str_replace('{rawfulltext}', $rawfulltext, $itemhtml);
$itemhtml = str_replace('{fulltext}', $fulltext, $itemhtml);
$itemhtml = str_replace('{introtext}', $intro, $itemhtml);
$itemhtml = str_replace('{introimage}', $img, $itemhtml);
$itemhtml = str_replace('{fullimage}', $fullimg, $itemhtml);
$itemhtml = str_replace('{category}', $item->cat_title, $itemhtml);
$itemhtml = str_replace('{categoryimageurl}', $categoryimageurl, $itemhtml);
$itemhtml = str_replace('{categoryimage}', $categoryimage, $itemhtml);
$itemhtml = str_replace('{categoryurl}', $categorylink, $itemhtml);
$itemhtml = str_replace('{date}', date($dateformat, $item->created), $itemhtml);
$itemhtml = str_replace('{moddate}', date($dateformat, $item->modified), $itemhtml);
$itemhtml = str_replace('{author}', $item->author, $itemhtml);
$itemhtml = str_replace('{authorname}', $item->authorname, $itemhtml);
$itemhtml = str_replace('{avatar}', $avatarimg, $itemhtml);
$itemhtml = str_replace('{authorprofile}', $authorlink, $itemhtml);
$itemhtml = str_replace('{index}', $index, $itemhtml);
$itemhtml = str_replace('{hits}', $item->hits, $itemhtml);
$itemhtml = str_replace('{comments}', $comments, $itemhtml);
$itemhtml = str_replace( '{readinglist}', $readinglist, $itemhtml );
$itemhtml = str_replace( '{categorydescription}', $item->cat_description, $itemhtml );
$itemhtml = str_replace( '{categorydescription_text}', strip_tags($item->cat_description), $itemhtml );
$itemhtml = str_replace( '{categoryalias}', $item->cat_alias, $itemhtml );

while (($ini = Jstring::strpos($itemhtml, "{date")) !== false) {
    $fin = Jstring::strpos($itemhtml, "}", $ini);
    $filter = Jstring::substr($itemhtml, $ini, $fin - $ini + 1);
    list($null, $fmt) = explode(' ', Jstring::substr($filter, 1, -1));
    $val = date(Jstring::trim($fmt), $item->created);
    $itemhtml = str_replace($filter, $val, $itemhtml);
}
?>