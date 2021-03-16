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
 defined( '_JEXEC' ) or die(); class com_aimysitemapInstallerScript { const V_JOOMLA_MIN = '3.0'; const V_PHP_MIN = '5.3.10'; static private $db_support = array( 'mysql', 'mysqli', 'pdomysql' ); public function preflight( $type, $parent ) { $app = JFactory::getApplication(); $db = $app->getCfg( 'dbtype', '' ); if ( ! in_array( $db, self::$db_support ) ) { $app->enqueueMessage( 'You are currently using <strong>' . $db . '</strong> ' . 'as a database backend for your Joomla! installation. ' . 'Aimy Sitemap at the moment only supports the following ' . 'database backends: ' . '<b>' . implode( ', ', self::$db_support ) . '</b>.', 'error' ); if ( $db == 'postgresql' ) { $app->enqueueMessage( '<strong>PostgreSQL</strong> support is available in ' . '<a href="https://www.aimy-extensions.com/joomla/sitemap.html" target="_blank">Aimy Sitemap ' . 'PRO</a>!' ); } else { $app->enqueueMessage( 'Please use the ' . '<a href="https://www.aimy-extensions.com//contact.html">contact ' . 'form on our website</a> to get in touch with us ' . 'if you would like us to implement support for ' . 'your database system as well.' ); } return false; } $dis_ini = str_replace( ' ', '', ini_get( 'disable_functions' ) . ',' . ini_get( 'suhosin.executor.func.blacklist' ) ); if ( $dis_ini !== ',' ) { $dis_fns = explode( ',', $dis_ini ); if ( in_array( 'stream_socket_client', $dis_fns ) ) { $app->enqueueMessage( 'The <code>stream_socket_client</code> PHP function is ' . 'currently disabled in your setup - Aimy Sitemap ' . 'requires this function to be ' . '<strong>enabled</strong> in order to crawl your ' . 'website. ' . 'Please fix your setup and install again.', 'error' ); return false; } } return ( self::check_php_version( self::V_PHP_MIN ) && self::check_joomla_version( self::V_JOOMLA_MIN ) ); } public function uninstall( $parent ) { require_once( JPATH_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_aimysitemap' . DIRECTORY_SEPARATOR . 'Sitemap.php' ); JFactory::getLanguage()->load( 'com_aimysitemap', JPATH_ADMINISTRATOR ); $sm = new AimySitemapSitemap(); $sm->unlink_file_if_exists(); } public function postflight( $route, $adapter ) { $task = strtolower( $route ); if ( $task != 'install' && $task != 'update' ) { return; } JFactory::getLanguage()->load( 'com_aimysitemap', JPATH_ADMINISTRATOR ); if ( $task == 'update' ) { require( __DIR__ . DIRECTORY_SEPARATOR . 'UpdateServer.php' ); AimySitemapUpdateServer::cleanup_server_list( $adapter ); JFactory::getApplication()->enqueueMessage( 'Aimy Sitemap: Each HTML sitemap now shows a ' . '<b>credits paragraph</b> including a backlink to Aimy ' . 'Sitemap\'s website - have a look at the FAQ on our ' . 'website if you like to disable it.', 'notice' ); } if ( $task == 'install' ) { self::check_disguise_mode_required(); } self::removeObsoleteFiles( array( 'urls-ajax-edit.js', 'crawl.js', 'ping.js', 'backend.css' ), JPATH_ADMINISTRATOR . '/components/com_aimysitemap/helpers/' ); self::removeObsoleteFiles( array( 'broadcast_64x64.png', 'sitemap_64x64.png', 'robot_64x64.png', 'stopwatch_64x64.png', 'goman_64x64.png', 'gear_64x64.png', 'link-404_64x64.png', 'go-up_32x32.png', 'wait-1.jpg', 'wait-2.jpg', 'wait-3.jpg' ), JPATH_ROOT . '/media/com_aimysitemap/' ); self::removeObsoleteFiles( array( 'com_aimysitemap.xml' ), JPATH_ADMINISTRATOR . '/components/com_aimysitemap/' ); if ( $task == 'install' ) { echo '<div style="padding:32px;text-align:center;">', '<h1>', '<img src="', JURI::base(), '../media/com_aimysitemap/aimy-logo_340x327.png" ', 'width="340" height="327" alt="Aimy" />', '<br/>', 'Aimy Sitemap  v28.0 ', '</h1>', '<p class="lead">', JText::_( $task == 'update' ? 'AIMY_SM_HINT_UPDATED' : 'AIMY_SM_HINT_INSTALLED' ), '!', '</p>'; echo '<p>', self::_btn( JRoute::_( 'index.php?option=com_aimysitemap' ), JText::_( 'AIMY_SM_HINT_DASHBOARD' ) ), ' &nbsp; ', self::_btn( 'https://www.aimy-extensions.com/joomla/sitemap.html#user-manual', JText::_( 'AIMY_SM_HINT_READ_MANUAL' ), true ), ' &nbsp; ', self::_btn( 'http://static.aimy-extensions.com/images/products/sitemap/com-aimy-sitemap.pdf?v=28.0', JText::_( 'AIMY_SM_HINT_DL_MANUAL' ), false ), '</p>', '<p style="padding:12px 0;" />', '<a href="https://www.aimy-extensions.com/joomla/sitemap.html" target="_blank">https://www.aimy-extensions.com/joomla/sitemap.html</a>', '</p>', '</div>', "\n"; } } static private function _btn( $url, $text, $new_tab = false ) { return '<a class="btn btn-lg btn-success" href="' . $url . '" ' . ( $new_tab ? 'target="_blank" ' : '' ) . 'role="button">' . $text . '!' . '</a>'; } static private function removeObsoleteFiles( $files, $basedir ) { foreach ( $files as $file ) { $path = $basedir . '/' . $file; if ( JFile::exists( $path ) ) { JFile::delete( $path ); } } } static private function check_php_version( $min ) { if ( version_compare( PHP_VERSION, $min, '<' ) ) { JFactory::getApplication()->enqueueMessage( 'You are currently using PHP ' . PHP_VERSION . ', ' . 'but Aimy Sitemap requires at least PHP ' . $min . '.', 'error' ); return false; } return true; } static private function check_joomla_version( $min ) { $jv = defined( 'JVERSION' ) ? JVERSION : 0; if ( version_compare( $jv, $min, '<' ) ) { JFactory::getApplication()->enqueueMessage( 'You are currently using Joomla! ' . $jv . ', ' . 'but Aimy Sitemap requires at least Joomla! ' . $min . '.', 'error' ); return false; } return true; } static private function check_disguise_mode_required() { require_once( JPATH_ADMINISTRATOR . '/components/com_aimysitemap/HttpClient.php' ); $url = new AimySitemapUri( JURI::root() ); try { $resp = AimySitemapHttpClient::head_url( $url ); if ( is_array( $resp ) && is_array( $resp[ 'head' ] ) && isset( $resp[ 'head' ][ 'code' ] ) && $resp[ 'head' ][ 'code' ] != '403' ) { return false; } AimySitemapHttpClient::set_disguise(); $resp = AimySitemapHttpClient::head_url( $url ); if ( is_array( $resp ) && is_array( $resp[ 'head' ] ) && isset( $resp[ 'head' ][ 'code' ] ) && $resp[ 'head' ][ 'code' ] == '200' ) { require_once( JPATH_ADMINISTRATOR . '/components/com_aimysitemap/helpers/config.php' ); AimySitemapConfigHelper::set_once( 'crawl_disguise', 1 ); JFactory::getApplication()->enqueueMessage( 'Aimy Sitemap: ' . 'Disguise-as-Browser mode has been automatically enabled.' ); return true; } else { JFactory::getApplication()->enqueueMessage( 'Aimy Sitemap: HEAD request on ' . $url->toString() . ' ' . 'failed with <b>status code 403 (forbidden)</b>, ' . 'even with disguise-as-browser mode enabled. ' . 'Check your access rules (i.e. <em>.htaccess</em>) and ' . 'make sure HEAD requests are allowed and AimySitemap\'s ' . 'crawler is not blocked from accessing your website.', 'error' ); } } catch ( Exception $e ) { JFactory::getApplication()->enqueueMessage( 'Aimy Sitemap: Disguise-as-Browser mode check: ' . $e->__toString() ); } return false; } } 
