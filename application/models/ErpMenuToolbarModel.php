<?php

class ErpMenuToolbarModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_menu_toolbars";
    }

    public function getAll(){

        $query= "
			SELECT
			menu_tab.`name_en` AS tab_en, menu_tab.`name_es` AS tab_es,
			menu_tab.`name_ca` AS tab_ca, menu_tab.`name_fr` AS tab_fr,
			menu_tab.`name_ge` AS tab_ge, menu_tab.`name_it` AS tab_it,
			menu_tab.`name_pt` AS tab_pt,
			menu_group.`name_en` AS group_en, menu_group.`name_es` AS
			group_es, menu_group.`name_ca` AS group_ca,
			menu_group.`name_fr` AS group_fr, menu_group.`name_ge` AS
			group_ge, menu_group.`name_it` AS group_it, menu_group.`name_pt`
			AS group_pt,
			menu_item.`name_en` AS item_en, menu_item.`name_es` AS item_es,
			menu_item.`name_ca` AS item_ca, menu_item.`name_fr` AS item_fr,
			menu_item.`name_ge` AS item_ge, menu_item.`name_it` AS item_it,
			menu_item.`name_pt` AS item_pt,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_en`,'')
			subitem_en,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_es`,'') subitem_es,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_ca`,'') subitem_ca,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_fr`,'') subitem_fr,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_ge`,'')
			subitem_ge,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_it`,'') subitem_it,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_pt`,'') subitem_pt,
			options_1.`keymenu` AS key_item,
			options_2.`keymenu` AS key_subitem
			FROM erp_menu_toolbars AS menu_bar
			LEFT JOIN erp_menu_toolbar_tab AS menu_tab
			ON menu_bar.`id` = menu_tab.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_group AS menu_group
			ON menu_tab.`id` = menu_group.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_group.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_item AS menu_item
			ON menu_group.`id` = menu_item.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_item.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_item.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_subitem AS menu_subitem
			ON menu_item.`id` = menu_subitem.`id_erp_menu_toolbar_item`
			AND menu_group.`id` =
			menu_subitem.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_subitem.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_subitem.`id_menu_toolbars`
			LEFT JOIN erp_options AS options_1
			ON menu_item.`id_option` = options_1.`id`
			LEFT JOIN erp_options AS options_2
			ON menu_subitem.`id_option` = options_2.`id`
			WHERE menu_bar.`id` = 1
			;";

        return $this->selectCustom($query);
    }

    public function getAllEn(){

        $query= "
			SELECT
			menu_tab.`name_en` AS name_tab,
			menu_group.`name_en` AS name_group,
			menu_item.`name_en` AS name_item,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_en`,'') name_subitem,
			options_1.`keymenu` AS key_item,
			options_2.`keymenu` AS key_subitem
			FROM erp_menu_toolbars AS menu_bar
			LEFT JOIN erp_menu_toolbar_tab AS menu_tab
			ON menu_bar.`id` = menu_tab.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_group AS menu_group
			ON menu_tab.`id` = menu_group.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_group.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_item AS menu_item
			ON menu_group.`id` = menu_item.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_item.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_item.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_subitem AS menu_subitem
			ON menu_item.`id` = menu_subitem.`id_erp_menu_toolbar_item`
			AND menu_group.`id` = menu_subitem.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_subitem.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_subitem.`id_menu_toolbars`
			LEFT JOIN erp_options AS options_1
			ON menu_item.`id_option` = options_1.`id`
			LEFT JOIN erp_options AS options_2
			ON menu_subitem.`id_option` = options_2.`id`
			WHERE menu_bar.`id` = 1
			AND menu_tab.`visible`=1 AND menu_group.`visible` = 1 AND
			menu_item.visible=1
			ORDER BY 1,2,3,4
			;";

        return $this->selectCustom($query);
    }

    public function getAllEs(){

        $query= "
			SELECT
			menu_tab.`name_es` AS name_tab,
			menu_group.`name_es` AS name_group,
			menu_item.`name_es` AS name_item,
			IF(menu_subitem.`visible`=1, menu_subitem.`name_es`,'') name_subitem,
			options_1.`keymenu` AS key_item,
			options_2.`keymenu` AS key_subitem
			FROM erp_menu_toolbars AS menu_bar
			LEFT JOIN erp_menu_toolbar_tab AS menu_tab
			ON menu_bar.`id` = menu_tab.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_group AS menu_group
			ON menu_tab.`id` = menu_group.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_group.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_item AS menu_item
			ON menu_group.`id` = menu_item.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_item.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_item.`id_erp_menu_toolbars`
			LEFT JOIN erp_menu_toolbar_subitem AS menu_subitem
			ON menu_item.`id` = menu_subitem.`id_erp_menu_toolbar_item`
			AND menu_group.`id` = menu_subitem.`id_erp_menu_toolbar_group`
			AND menu_tab.`id` = menu_subitem.`id_erp_menu_toolbar_tab`
			AND menu_bar.`id` = menu_subitem.`id_menu_toolbars`
			LEFT JOIN erp_options AS options_1
			ON menu_item.`id_option` = options_1.`id`
			LEFT JOIN erp_options AS options_2
			ON menu_subitem.`id_option` = options_2.`id`
			WHERE menu_bar.`id` = 1
			AND menu_tab.`visible`=1 AND menu_group.`visible` = 1 AND
			menu_item.visible=1
			ORDER BY 1,2,3,4
			;";

        return $this->selectCustom($query);
    }


}