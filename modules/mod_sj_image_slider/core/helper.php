<?php
/**
 * @package Sj Image Slider
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper_base.php';

class SJImageSliderHelper extends SJImageSliderBaseHelper
{
    public static function getList($params)
    {
		$count_items = (int)$params->get('count_items',5);
		$sort = $params->get('sort',0);
		$orderby = $params->get('orderby',0);
		$path = $params->get('folder');
		$description = $params->get('description');
		$list = array();
		$images_path = array();
		$path = self::checkUrl($path);
		$files = self::getExternalImages($path);

		if(count($files)){
			for ($i=0; $i<count($files); $i++){
				$path_parts = pathinfo($files[$i]);
				$basename = $path_parts['basename'];
				$src = $files[$i];
				$list[$basename] = array('id'=>$i,'src'=>$src,'name'=>$basename,'time'=>filemtime($files[$i]));
			}
		}
		if(!empty($list)) {
			if(trim($description) !=''){
				$desc = self::parseDesc($description);
			}
			foreach($list as $key=> $item){
				if(isset($desc[$key])){
					$list[$key] = array_merge($list[$key],$desc[$key]);
				}
			}
			$list = self::sortImage($list, $orderby , $sort);
			$list = ($count_items > 0)?array_slice($list, 0 ,$count_items ):$list;
			$list = (count($list) >= 20 )?array_slice($list, 0 ,20 ):$list;

			foreach($list as $key=> &$tem){
				self::getJSAImage($tem, $params);
			}

			return $list;
		}

    }

	private static function checkUrl($url){

		if(is_dir($url)){
			$url = (substr($url,-1,1) == "/")?substr($url,0,-1):$url;
			return $url;
		}else {
			//echo "<b>Folder doesn't exists. Please add correct path in the module parameters</b>";
			return false;
		}
	}

	private static function parseDesc($desc){
		$desc = trim($desc);
		$desc = str_replace("<br />", "\n", $desc);

		$descs = explode("\n",$desc);
		$data = array();
		$list = array();
		foreach($descs as $desc){
			if(strpos($desc,':')){
				$list[0] = substr($desc,0,strpos($desc,':'));
				$var_temp = substr($desc,strlen($list[0])+1);
				$list[1] = ($var_temp !='')?preg_split('/&/',$var_temp):array();
				$temp = array();
				if(count($list[1])){
					for($i = 0; $i < count($list[1]); $i++){
						$mark = preg_split('/=/', $list[1][$i]);
						$temp[trim($mark[0])] = trim($mark[1]);
					}
				}
				$data[$list[0]] = $temp;
			}
		}
		return $data;
	}

	private static function sortImage($images, $orderby , $sort){
		$data = array();
		$list = array();
		$data = $images;
		foreach($data as $key => $row){
			$filename[$key] = $row['name'];
			$time[$key] = $row['time'];
		}
		switch($orderby){
			case 0:
				switch($sort){
					case 0:
						shuffle($data);
						break;
					case 1:
						array_multisort($filename, SORT_ASC, $data);
						break;
					case 2:
						array_multisort($filename, SORT_DESC, $data);
						break;
					default:
						break;
				}
				break;
			case 1:
				switch($sort){
					case 0:
						$listSort = shuffle($data);
						break;
					case 1:
						array_multisort($time, SORT_ASC, $data);
						break;
					case 2:
						array_multisort($time, SORT_DESC, $data);
						break;
					default:
						break;
				}
				break;
			default:
				break;
		}

		foreach($data as  $item){
			$list[$item['name']]= $item;
		}
		return $list;
	}
}
