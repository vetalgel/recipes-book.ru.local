<?php
/*
	JoomlaXTC K2 Comments Wall

	version 1.8.0

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


$articlelink = JRoute::_(K2HelperRoute::getItemRoute($item->slug, $item->catslug));
$categorylink = JRoute::_(K2HelperRoute::getCategoryRoute($item->catslug));

$author_id = $item->itemauthor;
$commentor_id = $item->userID;
$authordata;
$commentordata;
$author_name = mod_jxtc_k2commentswallHelper::getAuthorName( $author_id );

$aux = $params->get('compat');

if ($aux){
    $authordata = mod_jxtc_k2commentswallHelper::getAvatarData( $aux, $author_id, $avatarw, $avatarh );
    $commentordata = mod_jxtc_k2commentswallHelper::getAvatarData( $aux, $commentor_id , $avatarw, $avatarh);
}
else{
    $authordata[0] = '';
    $authordata[1] = '';
    $commentordata[0] = '';
    $commentordata[1] = '';
}

$comment = $item->commentText;
$comment = $maxlength > 0 ? substr($comment,0,$maxlength) : $comment;

$itemhtml = str_replace( '{catname}', htmlspecialchars($item->catname), $itemhtml );
$itemhtml = str_replace( '{title}', htmlspecialchars($item->itemname), $itemhtml );
$itemhtml = str_replace( '{author}', htmlspecialchars($author_name), $itemhtml );
$itemhtml = str_replace( '{comment}', $comment, $itemhtml );
$itemhtml = str_replace( '{date}', date($dateformat,strtotime($item->commentDate)), $itemhtml );
$itemhtml = str_replace( '{articleurl}', $articlelink, $itemhtml );
$itemhtml = str_replace( '{categoryurl}', $categorylink, $itemhtml );
$itemhtml = str_replace( '{authoravatar}', $authordata[0], $itemhtml );
$itemhtml = str_replace( '{authorlink}', $authordata[1], $itemhtml );
$itemhtml = str_replace( '{commentoravatar}', $commentordata[0], $itemhtml );
$itemhtml = str_replace( '{commentorlink}', $commentordata[1], $itemhtml );
$itemhtml = str_replace( '{username}', $item->userName, $itemhtml );
$itemhtml = str_replace( '{email}', $item->commentEmail, $itemhtml );
$itemhtml = str_replace( '{homepage}', $item->commentURL, $itemhtml );

while (($ini=strpos($itemhtml,"{date ")) !== false) {
	$fin = strpos($itemhtml,"}",$ini);
	$filter=substr($itemhtml,$ini,$fin-$ini+1);
	list($null,$fmt)=explode(' ',substr($filter,1,-1));
	$val=date(trim($fmt),$item->commentDate);
	$itemhtml = str_replace($filter,$val,$itemhtml);
}
?>