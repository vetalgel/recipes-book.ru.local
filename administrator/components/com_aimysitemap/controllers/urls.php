<?php
/*
 * Copyright (c) 2017-2020 Aimy Extensions, Netzum Sorglos Software GmbH
 * Copyright (c) 2014-2017 Aimy Extensions, Lingua-Systems Software GmbH
 *
 * https://www.aimy-extensions.com/
 *
 * License: GNU GPLv2, see LICENSE.txt within distribution and/or
 *          https://www.aimy-extensions.com/software-license.html
 */
 defined( '_JEXEC' ) or die(); jimport( 'joomla.session.session' ); require_once( JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'rights.php' ); class AimySitemapControllerUrls extends JControllerAdmin { public function getModel( $name = 'Urls', $prefix = 'AimySitemapModel', $config = array( 'ignore_request' => true ) ) { return parent::getModel( $name, $prefix, $config ); } public function write() { JSession::checkToken() or jexit( JText::_( 'INVALID TOKEN' ) ); $rights = AimySitemapRightsHelper::getRights(); if ( ! $rights->get( 'aimysitemap.write' ) ) { $this->setError( JText::_( 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN' ) ); $this->setMessage( $this->getError(), 'error' ); } else { require_once( JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'Sitemap.php' ); $sm = new AimySitemapSitemap(); $sm->write_sitemap_file(); } $this->setRedirect( JRoute::_( 'index.php?option=com_aimysitemap&view=urls', false ) ); } public function reset_index() { JSession::checkToken() or jexit( JText::_( 'INVALID TOKEN' ) ); $rights = AimySitemapRightsHelper::getRights(); if ( ! $rights->get( 'core.edit' ) ) { $this->setError( JText::_( 'JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN' ) ); $this->setMessage( $this->getError(), 'error' ); } else { $this->getModel()->reset_index(); $this->setMessage( JText::_( 'AIMY_SM_MSG_INDEX_RESET' ) ); } $this->setRedirect( JRoute::_( 'index.php?option=com_aimysitemap&view=urls', false ) ); } public function activate() { return $this->_set_bool_by_input_and_redirect( 'state', 1, JText::_( 'AIMY_SM_MSG_ACTIVATED' ), JText::_( 'AIMY_SM_MSG_DEACTIVATED' ) ); } public function deactivate() { return $this->_set_bool_by_input_and_redirect( 'state', 0, JText::_( 'AIMY_SM_MSG_ACTIVATED' ), JText::_( 'AIMY_SM_MSG_DEACTIVATED' ) ); } private function _set_bool_by_input_and_redirect( $field, $state, $msg_on, $msg_off ) { JSession::checkToken() or jexit( JText::_( 'INVALID TOKEN' ) ); $rights = AimySitemapRightsHelper::getRights(); if ( ! $rights->get( 'core.edit' ) ) { $this->setError( JText::_( 'JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED' ) ); $this->setMessage( $this->getError(), 'error' ); $this->setRedirect( JRoute::_( 'index.php?option=com_aimysitemap&view=urls', false ) ); return false; } require_once( JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'message.php' ); $msg = new AimySitemapMessageHelper(); $jin = JFactory::getApplication()->input; $ids = self::_to_int_array( $jin->get( 'cid', array(), 'ARRAY' ) ); $model = $this->getModel( 'Url', 'AimySitemapModel' ); $method = "set_$field"; if ( ! method_exists( $model, $method ) ) { $this->setError( JText::_( 'JERROR_AN_ERROR_HAS_OCCURRED' ) ); $this->setMessage( $this->getError(), 'error' ); $this->setRedirect( JRoute::_( 'index.php?option=com_aimysitemap&view=urls', false ) ); return false; } $n = 0; foreach ( $ids as $id ) { if ( $id <= 0 ) { $msg->error( JText::_( 'JERROR_AN_ERROR_HAS_OCCURRED' ) ); continue; } $model->$method( $id, $state ); $n++; } if ( $n ) { $msg->queue( sprintf( $state == 1 ? $msg_on : $msg_off, count( $ids ) ) ); } $this->setRedirect( JRoute::_( 'index.php?option=com_aimysitemap&view=urls', false ) ); return true; } static private function _to_int_array( $arr ) { if ( ! is_array( $arr ) or empty( $arr ) ) { return array(); } return array_map( 'intVal', $arr ); } } 
