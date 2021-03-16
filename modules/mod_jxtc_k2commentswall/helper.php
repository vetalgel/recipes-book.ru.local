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


class mod_jxtc_k2commentswallHelper
{
    public static function getData( $userid, $sortorder, $filtertags, $limit ){
        $db = JFactory::getDBO();

        $query = "SELECT c.userID, c.userName, c.commentDate, c.commentText, c.commentEmail,
            c.commentURL, i.id AS itemid, i.title AS itemname, i.created_by AS itemauthor,
            cat.name AS catname, cat.id AS catid, CASE WHEN CHAR_LENGTH(i.alias)
            THEN CONCAT_WS(':', i.id, i.alias) ELSE i.id END as slug, CASE WHEN CHAR_LENGTH(cat.alias)
            THEN CONCAT_WS(':', cat.id, cat.alias) ELSE cat.id END as catslug FROM #__k2_comments AS c,
            #__k2_items AS i, #__k2_categories AS cat WHERE c.published = '1'
            AND i.published = '1' AND i.trash = '0' AND cat.trash = '0' AND
            cat.published = '1' AND c.itemID = i.id AND cat.id = i.catid";

        if ($userid) {
            if(is_array($userid)){
                if($userid[0] != 0){
                    if ($userid[0] == '*')
                        $userid[0] = 0;

                    $query .= ' AND (c.userID=' . implode( ' OR c.userID=', $userid ) . ')';
                }
            }
            else{
                if ($userid == '*'){
                    $query .= " AND (c.userID = '0' )";
                }
                else{
                    $query .= " AND (c.userID= '$userid')";
                }
            }
        }

        if ($filtertags) {
            $filtertags=explode(',',$filtertags);
            JArrayHelper::toString($filtertags);
            $query .= ' AND (i.title like "% ' . implode( ' %" OR i.title like "% ', $filtertags ) . ' %")';
        }

        switch ($sortorder) {
            case 0:
                    $query .= ' ORDER BY RAND()';
            break;
            case 1: // creation
                    $query .= ' ORDER BY c.commentDate DESC';
            break;
        }

        $db->setQuery($query, 0, $limit);
        $items = $db->loadObjectList();

        return $items;
    }

    public static function getAvatarData($aux, $author_id, $avatarw, $avatarh){
        $db = JFactory::getDBO();
        $live_site = JURI::base();
        $authorimg = "";
        $authorlink = "";

        switch ($aux) {
            case 0:
            break;
            case 1:
                    $db->setQuery("SELECT avatar from #__comprofiler WHERE user_id = '$author_id'");
                    $avatar = $db->loadResult();
                    $authorimg = empty($avatar) ? '' : "<img src=\"".$live_site."components/com_comprofiler/images/$avatar\" alt='Avatar' border=\"0\" $avatarw $avatarh />";
                    $db->setQuery("SELECT id from #__components WHERE link = 'option=com_comprofiler' and enabled='1'");
                    $itemid2 = $db->loadResult();if ($itemid2) { $itemid2 = '&Itemid='.$itemid2; }
                    $authorlink = JRoute::_($live_site.'index.php?option=com_comprofiler&view=profile&userid='.$author_id.$itemid2);
            break;
            case 2:
                    if (!isset($itemid2)) {
                            $db->setQuery("SELECT id from #__components WHERE link = 'option=com_community' and enabled='1'");
                            $itemid2 = $db->loadResult();$itemid2 = empty($itemid2) ? '' : '&Itemid='.$itemid2;
                    }
                    $db->setQuery("SELECT avatar from #__community_users WHERE userid = '$author_id'");
                    $avatar = $db->loadResult();
                    $authorimg = empty($avatar) ? '' : "<img src=\"$live_site$avatar\" alt='Avatar' border=\"0\" $avatarw $avatarh />";
                    $authorlink = JRoute::_($live_site.'index.php?option=com_community&view=profile&userid='.$author_id.$itemid2);
            break;
            case 3:
                    if (!isset($itemid2)) {
                            $db->setQuery("SELECT id from #__components WHERE link = 'option=com_fireboard' and enabled='1'");
                            $itemid2 = $db->loadResult();if ($itemid2) { $itemid2 = '&Itemid='.$itemid2; }
                    }
                    $db->setQuery("SELECT avatar from #__fb_users WHERE userid = '$author_id'");
                    $avatar = $db->loadResult();
                    $authorimg = empty($avatar) ? '': "<img src=\"".$live_site."images/fbfiles/avatars/$avatar\" alt='Avatar' border=\"0\" $avatarw $avatarh />";
                    $authorlink = JRoute::_($live_site.'index.php?option=com_fireboard&func=fbprofile&task=showprf&userid='.$author_id.$itemid2);
            break;
            case 4:
                    if (!isset($itemid2)) {
                            $db->setQuery("SELECT id from #__components WHERE link = 'option=com_kunena' and enabled='1'");
                            $itemid2 = $db->loadResult();if ($itemid2) { $itemid2 = '&Itemid='.$itemid2; }
                    }
                    $db->setQuery("SELECT avatar from #__fb_users WHERE userid = '$author_id'");
                    $avatar = $db->loadResult();
                    $authorimg = empty($avatar) ? "<img src=\"".$live_site."images/fbfiles/avatars/nophoto.jpg\" alt='Avatar' border=\"0\" $avatarw $avatarh />"
                                                : "<img src=\"".$live_site."images/fbfiles/avatars/$avatar\" alt='Avatar' border=\"0\" $avatarw $avatarh />";
                    $authorlink = JRoute::_($live_site.'index.php?option=com_kunena&func=fbprofile&userid='.$author_id.$itemid2);
            break;
            case 5:
                    $db->setQuery("SELECT image from #__k2_users WHERE userID = '$author_id'");
                    $avatar = $db->loadResult();
                    $authorimg = empty($avatar) ? "<img src=\"".$live_site."components/com_k2/images/placeholder/user.png\" border=\"0\" $avatarw $avatarh />"
                    : "<img src=\"".$live_site."media/k2/users/$avatar\" border=\"0\" $avatarw $avatarh />";
                    $authorlink = JRoute::_($live_site.'index.php?option=com_k2&view=itemlist&task=user&id='.$author_id);
            break;
						case 6:
							if (!class_exists("KomentoProfile")) {
								require_once( JPATH_ROOT.'/components/com_komento/bootstrap.php' );
								require_once( KOMENTO_CLASSES.'/profile.php' );
							}
							$komento_user = new KomentoProfile($author_id);
							$avatarimg = "<img src=\"".$komento_user->getAvatar()."\" border=\"0\" $avatarw $avatarh />";
							$authorlink = $komento_user->getProfileLink();
						break;
        }

        return array($authorimg, $authorlink);
    }

    public static function getAuthorName($author_id){
        $db = JFactory::getDBO();

        $db->setQuery("SELECT userName from #__k2_users WHERE userID = '$author_id'");
        $name = $db->loadResult();

        return $name;
    }
}
?>