<?php
/**
 * @package SJ JS Categories for JoomShopping
 * @version 1.0.0
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2014 YouTech Company. All Rights Reserved.
 * @author YouTech Company http://www.smartaddons.com
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper_base.php';

class SJJSCategoriesHelper extends SJJSCategoriesBaseHelper
{
    public static function getList($params)
    {
        $catids = $params->get('catids');
        if (empty($catids)) return;
        $list = array();
        $order = $params->get('cat_order_by', 'id');
        $ordering = $params->get('cat_ordering', 'ASC');
        $limit_start = 0;
        $_limit = $params->get('source_limit_category', 5);
        $limit = $_limit <= 0 ? 999: $params->get('source_limit_category', 5);
        $_list = self::getCategoryInfo($catids, $order, $ordering, 1, $limit_start, $limit);
        if (empty($_list)) return;
        foreach ($_list as $item) {
            $item->child_cat = self::_getChildrenCat($item->category_id, $params);
            $list[] = $item;
        }

        return $list;
    }

    private static function _getChildrenCat($cat_id, $params)
    {
        $pro_table = JTable::getInstance('product', 'jshop');
        $items = array();
        $_list = array();
        $levels = (int)$params->get('levels', 1) <= 0 ? 999 : (int)$params->get('levels', 1);
        if ($levels > 0) {
            $_list = self::_getChildenCategories($cat_id, $levels);
        }

        $order = $params->get('cat_order_by', 'id');
        $ordering = $params->get('cat_ordering', 'ASC');
        $limit_start = 0;
        $_limit = $params->get('source_limit_category', 5);
        $limit = $_limit <= 0 ? 999: $params->get('source_limit_category', 5);

        if(empty($_list)) return;
        $list = self::getCategoryInfo($_list, $order, $ordering, 1, $limit_start, $limit);

        return $list;
    }

    public static function _getAllProducts($filters, $order = null, $orderby = null, $limitstart = 0, $limit = 0)
    {
        $_db = JFactory::getDBO();
        $pro_table = JTable::getInstance('product', 'jshop');
        $jshopConfig = JSFactory::getConfig();
        $lang = JSFactory::getLang();
        $adv_query = "";
        $adv_from = "";
        $adv_result = $pro_table->getBuildQueryListProductDefaultResult();
        $pro_table->getBuildQueryListProduct("products", "list", $filters, $adv_query, $adv_from, $adv_result);
        if ($order == 'best_seller') {
            $orderby = ' DESC ';
        }
        $order_query = $pro_table->getBuildQueryOrderListProduct($order, $orderby, $adv_from);
        JPluginHelper::importPlugin('jshoppingproducts');
        $dispatcher = JDispatcher::getInstance();
        $dispatcher->trigger('onBeforeQueryGetProductList', array("all_products", &$adv_result, &$adv_from, &$adv_query, &$order_query, &$filters));
        $query = "SELECT distinct prod.product_id , SUM(OI.product_quantity) as best_seller, $adv_result FROM `#__jshopping_products` AS prod
                  LEFT JOIN `#__jshopping_products_to_categories` AS pr_cat USING (product_id)
                  LEFT JOIN `#__jshopping_categories` AS cat ON pr_cat.category_id = cat.category_id
				  LEFT JOIN `#__jshopping_order_item` AS OI  ON prod.product_id = OI.product_id
                  $adv_from
                  WHERE prod.product_publish = '1' AND cat.category_publish='1' " . $adv_query . "
                  GROUP BY prod.product_id " . $order_query;
        if ($limit) {
            $_db->setQuery($query, $limitstart, $limit);
        } else {
            $_db->setQuery($query);
        }
        $products = $_db->loadObjectList();
        $products = listProductUpdateData($products);
        addLinkToProducts($products, 0, 1);
        return $products;
    }

    private static function getCategoryTree($parentId = 0, $level = 0, $onlyPublished = true)
    {
        $sortedCats = array();
        self::_rekurseCats($parentId, $level, $onlyPublished, $sortedCats);
        return $sortedCats;
    }

    private static function _rekurseCats($category_id, $level, $onlyPublished, &$sortedCats)
    {
        $level++;
        $cat_table = JTable::getInstance('category', 'jshop');
        $childCats = $cat_table->getSubCategories($category_id, null, null, $onlyPublished);
        if (!empty($childCats)) {
            foreach ($childCats as $key => $category) {
                $category->level = $level;
                $sortedCats[] = $category;
                self::_rekurseCats($category->category_id, $level, $onlyPublished, $sortedCats);
            }
        }

    }

    private static function _getChildenCategories($catids, $levels)
    {
        !is_array($catids) && settype($catids, 'array');
        if (!empty ($catids)) {
            $additional_catids = array();
            foreach ($catids as $catid) {
                $items = self::getCategoryTree($catid);
                if (!empty($items)) {
                    foreach ($items as $category) {
                        $condition = $category->level <= $levels;
                        if ($condition) {
                            $additional_catids[] = (int)$category->category_id;
                        }
                    }
                }
            }

            $catids = array_unique($additional_catids);
        }

        return $catids;
    }

    private static function getCategoryInfo($catid, $order = 'id', $ordering = 'asc', $publish = 1, $limit_start = 0, $limit = 0)
    {
        $_db = JFactory::getDBO();
        $lang = JSFactory::getLang();
        $user = JFactory::getUser();
        $add_where = ($publish) ? (" AND category_publish = '1' ") : ("");
        $groups = implode(',', $user->getAuthorisedViewLevels());
        $add_where .= ' AND access IN (' . $groups . ')';
        if ($order == "id") $orderby = "category_id";
        if ($order == "name") $orderby = "`" . $lang->get('name') . "`";
        if ($order == "ordering") $orderby = "ordering";
        if ($order == "random") {
            $orderby = "rand()";
            $ordering = '';
        }
        if (!$orderby) $orderby = "ordering";

        !is_array($catid) && settype($catid, 'array');
        if ($catid) {
            $_catid = implode(', ', $catid);
        }
        $query = "SELECT `" . $lang->get('name') . "` as name,`" . $lang->get('description') . "` as description,`" . $lang->get('short_description') . "` as short_description, category_id, category_parent_id, category_publish, ordering, category_image FROM `#__jshopping_categories`
                   WHERE category_id IN (" . $_catid . ") " . $add_where . "
                   ORDER BY " . $orderby . " " . $ordering;
        $_db->setQuery($query);
        if ($limit) {
            $_db->setQuery($query, $limit_start, $limit);
        } else {
            $_db->setQuery($query);
        }
        $categories = $_db->loadObjectList();
        $pro_table = JTable::getInstance('product', 'jshop');
        $fiters = array();
        foreach ($categories as $key => $value) {
            $fiters['categorys'] = array($value->category_id);
            $categories[$key]->_totalProduct = $pro_table->getCountAllProducts($fiters);
            $categories[$key]->cat_link = SEFLink('index.php?option=com_jshopping&controller=category&task=view&category_id=' . $categories[$key]->category_id, 1);
        }
        return $categories;
    }


    private static function getLabel($_order)
    {
        switch ($_order) {
            case 'name' :
                return JText::_('NAME');
            case 'prod.product_price' :
                return JText::_('PRICE');
            case 'best_seller':
                return JTEXT::_('BEST_SELLER');
            case 'prod.reviews_count' :
                return JText::_('REVIEWS_COUNT');
            case 'prod.average_rating':
                return JText::_('AVERAGE_RATING');
            case 'prod.hits' :
                return JText::_('HITS');
            case 'prod.product_id':
                return JText::_('PRODUCT_ID');
            case 'prod.product_date_added':
                return JText::_('PRODUCT_DATE_ADDED');
            case 'prod.date_modify':
                return JText::_('DATE_MODIFY');
            case 'random':
                return JText::_('RANDOM');
        }
    }


}
