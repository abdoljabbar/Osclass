<?php

    /*
     *      OSCLass – software for creating and publishing online classified
     *                           advertising platforms
     *
     *                        Copyright (C) 2010 OSCLASS
     *
     *       This program is free software: you can redistribute it and/or
     *     modify it under the terms of the GNU Affero General Public License
     *     as published by the Free Software Foundation, either version 3 of
     *            the License, or (at your option) any later version.
     *
     *     This program is distributed in the hope that it will be useful, but
     *         WITHOUT ANY WARRANTY; without even the implied warranty of
     *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *             GNU Affero General Public License for more details.
     *
     *      You should have received a copy of the GNU Affero General Public
     * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
     */

    //URL Helpers
    function osc_base_url($with_index = false) {
        $path = WEB_PATH ;
        if ($with_index) $path .= "index.php" ;
        return($path) ;
    }

    function osc_admin_base_url($with_index = false) {
        $path = WEB_PATH . "oc-admin/" ;
        if ($with_index) $path .= "index.php" ;
        return($path) ;
    }
    
    function osc_ajax_plugin_url($file = '') {
        return(WEB_PATH . "index.php?page=ajax&file=" . $file);
    }

    function osc_admin_configure_plugin_url($file = '') {
        return(osc_base_url() . "oc-admin/index.php?page=plugins&action=configure&plugin=" . $file);
    }

    function osc_admin_render_plugin_url($file = '') {
        return(osc_base_url() . "oc-admin/index.php?page=plugins&action=renderplugin&file=" . $file);
    }

    function osc_admin_render_plugin($file = '') {
        header('Location: ' . osc_admin_render_plugin_url($file) ) ;
        exit ;
        //osc_redirectTo( osc_admin_render_plugin_url($file) ) ;
    }

    //Path Helpers
    function osc_base_path() {
        return(ABS_PATH) ;
    }

    function osc_admin_base_path() {
        return(osc_base_path() . "oc-admin/") ;
    }

    function osc_lib_path() {
        return(LIB_PATH) ;
    }

    function osc_themes_path() {
        return(THEMES_PATH) ;
    }

    function osc_plugins_path() {
        return(PLUGINS_PATH) ;
    }

    function osc_translations_path() {
        return(TRANSLATIONS_PATH) ;
    }

    function osc_css_url() {
        return(osc_base_url() . 'oc-includes/css/') ;
    }

    function osc_js_url() {
        return(osc_base_url() . 'oc-includes/js/') ;
    }

    //ONLY USED AT OC-ADMIN
    function osc_current_admin_theme() {
        return( AdminThemes::newInstance()->getCurrentTheme() ) ;
    }

    function osc_current_admin_theme_url($file = '') {
        return AdminThemes::newInstance()->getCurrentThemeUrl() . $file ;
    }
    
    function osc_current_admin_theme_path($file = '') {
        return AdminThemes::newInstance()->getCurrentThemePath() . $file ;
    }

    function osc_current_admin_theme_styles_url($file = '') {
        return AdminThemes::newInstance()->getCurrentThemeStyles() . $file ;
    }

    function osc_current_admin_theme_js_url($file = '') {
        return AdminThemes::newInstance()->getCurrentThemeJs() . $file ;
    }

    //ONLY USED AT PUBLIC WEBSITE
    function osc_current_web_theme() {
        return WebThemes::newInstance()->getCurrentTheme() ;
    }

    function osc_current_web_theme_url($file = '') {
        return WebThemes::newInstance()->getCurrentThemeUrl() . $file ;
    }

    function osc_current_web_theme_path($file = '') {
        return WebThemes::newInstance()->getCurrentThemePath() . $file ;
    }

    function osc_current_web_theme_styles_url($file = '') {
        return WebThemes::newInstance()->getCurrentThemeStyles() . $file ;
    }

    function osc_current_web_theme_js_url($file = '') {
        return WebThemes::newInstance()->getCurrentThemeJs() . $file ;
    }

    
    /////////////////////////////////////
    //functions for the public website //
    /////////////////////////////////////


    //osc_createItemPostURL
    function osc_item_post_url_in_category() {
        $category = osc_category() ;
        
        if ($category != '' && isset($category['pk_i_id'])) {
            if ( osc_rewrite_enabled() ) {
                $path = osc_base_url() . 'item/new/' . $category['pk_i_id'] ;
            } else {
                $path = sprintf(osc_base_url(true) . '?page=item&action=item_add&catId=%d', $category['pk_i_id']) ;
            }
        } else {
            $path = osc_item_post_url() ;
        }
        return $path ;
    }

    function osc_item_post_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'item/new' ;
        } else {
            $path = sprintf(osc_base_url(true) . '?page=item&action=item_add') ;
        }
        return $path ;
    }

    /**
     * Create automatically the url of a category
     *
     * @param array $cat An array with the category information
     * @param bool $echo If you want to echo or not the path automatically
     * @return string If $echo is false, it returns the path, if not it return blank string
     */
    //osc_createSearchURL y lo mismo con category...
    function osc_search_category_url($pattern = '') {
        $category = osc_category() ;

        $path = '' ;
        if ( osc_rewrite_enabled() ) {
            if ($category != '') {
                $category = Category::newInstance()->hierarchy($category['pk_i_id']) ;
                $sanitized_category = "" ;
                for ($i = count($category); $i > 0; $i--) {
                    $sanitized_category .= $category[$i - 1]['s_slug'] . '/' ;
                }
                $path = osc_base_url() . $sanitized_category ;
            }
            if ($pattern != '') {
                if ($path == '') {
                    $path = osc_base_url() . 'search/' . $pattern ;
                } else {
                    $path .= 'search/' . $pattern ;
                }
            }
        } else {
            $path = sprintf( osc_base_url(true) . '?page=search&sCategory=%d', $category['pk_i_id'] ) ;
        }
        return $path ;
    }

    //osc_createUserAccountURL
    function osc_user_dashboard_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/dashboard' ;
        } else {
            $path = osc_base_url(true) . '?page=user&action=dashboard' ;
        }
        return $path ;
    }

    //osc_createLogoutURL
    function osc_user_logout_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/logout' ;
        } else {
            $path = osc_base_url(true) . '?page=main&action=logout' ;
        }
        return $path ;
    }

    //
    function osc_user_login_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/login' ;
        } else {
            $path = osc_base_url(true) . '?page=login&action=login' ;
        }
        return $path ;
    }

    //osc_createRegisterURL
    function osc_register_account_url() {
        if ( osc_rewrite_enabled() ) {
            $path = osc_base_url() . 'user/register' ;
        } else {
            $path = osc_base_url(true) . '?page=register&action=register' ;
        }
        return $path ;
    }

    //osc_createItemURL
    function osc_item_url($item = null) {
        if($item==null) {
            return osc_base_url(true)."?page=item&id=".osc_item_id();        
        } else {//This part is deprecated
            if ( osc_rewrite_enabled() ) {
                $sanitized_title = osc_sanitizeString($item['s_title']) ;
                $sanitized_category = '';
                $cat = Category::newInstance()->hierarchy($item['fk_i_category_id']) ;
                for ($i = (count($cat)); $i > 0; $i--) {
                    $sanitized_category .= $cat[$i - 1]['s_slug'] . '/' ;
                }
                $path = osc_base_url() . sprintf('%s%s_%d', $sanitized_category, $sanitized_title, $item['pk_i_id']) ;
            } else {
                $path = osc_base_url(true) . sprintf('?page=item&id=%d', $item['pk_i_id']) ;
            }
            return $path ;
        }
    }

    //osc_createPageURL
    function osc_page_url($page) {
        if ( osc_rewrite_enabled() ) {
            $sanitizedString = osc_sanitizeString($page['s_title']);
            $path = sprintf(osc_base_url() . '%s-p%d', urlencode($sanitizedString), $page['pk_i_id']) ;
        } else {
            $path = sprintf(osc_base_url(true) . '?page=page&id=%d', $page['pk_i_id']) ;
        }
        return $path ;
    }

    //osc_createUserAlertsURL
    function osc_user_alerts_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/alerts' ;
        } else {
            return osc_base_url(true) . '?page=user&action=alerts' ;
        }
    }

    //osc_createProfileURL
    function osc_user_profile_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/profile' ;
        } else {
            return osc_base_url(true) . '?page=user&action=profile' ;
        }
    }

    //osc_createUserItemsURL
    function osc_user_list_items_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/items' ;
        } else {
            return osc_base_url(true) . '?page=user&action=items' ;
        }
    }

    function osc_change_user_email_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/change_email' ;
        } else {
            return osc_base_url(true) . '?page=user&action=change_email' ;
        }
    }

    function osc_change_user_email_confirm_url($userId, $code) {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/change_email_confirm/' . $userId . '/' . $code ;
        } else {
            return osc_base_url(true) . '?page=user&action=change_email_confirm&userId=' . $userId . '&code=' . $code ;
        }
    }

    function osc_change_user_password_url() {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'user/change_password' ;
        } else {
            return osc_base_url(true) . '?page=user&action=change_password' ;
        }
    }

    //doens't exists til now
    function osc_change_language_url($locale) {
        if ( osc_rewrite_enabled() ) {
            return osc_base_url() . 'language/' . $locale ;
        } else {
            return osc_base_url(true) . '?page=language&locale=' . $locale ;
        }
    }
    
    /////////////////////////////////////
    //       functions for items       //
    /////////////////////////////////////
    function osc_item_edit_url($secret = '') {
        if($secret!='') {
            return osc_base_url(true)."?page=item&action=item_edit&id=".osc_item_id()."&secret=".$secret;
        } else {
            return osc_base_url(true)."?page=item&action=item_edit&id=".osc_item_id();
        }
    }

    function osc_item_delete_url($secret = '') {
        if($secret!='') {
            return osc_base_url(true)."?page=item&action=item_delete&id=".osc_item_id()."&secret=".$secret;
        } else {
            return osc_base_url(true)."?page=item&action=item_delete&id=".osc_item_id();
        }
    }

    function osc_item_activate_url($secret = '') {
        if($secret!='') {
            return osc_base_url(true)."?page=item&action=activate&id=".osc_item_id()."&secret=".$secret;
        } else {
            return osc_base_url(true)."?page=item&action=activate&id=".osc_item_id();
        }
    }

    function osc_item_send_friend_url() {
        return osc_base_url(true)."?page=item&action=send_friend&id=".osc_item_id();
    }
    /////////////////////////////////////
    //functions for locations & search //
    /////////////////////////////////////


    function osc_list_countries() {
        if (View::newInstance()->_exists('countries')) {
            return View::newInstance()->_get('countries') ;
        } else {
            return Country::newInstance()->listAll() ;
        }
    }
    
    function osc_list_regions($country = '') {
        if (View::newInstance()->_exists('regions')) {
            return View::newInstance()->_get('regions') ;
        } else {
            if($country=='') {
                return Region::newInstance()->listAll() ;
            } else {
                return Region::newInstance()->getByCountry($country);
            }
        }
    }
    
    function osc_list_cities($region = '') {
        if (View::newInstance()->_exists('cities')) {
            return View::newInstance()->_get('cities') ;
        } else {
            if($region=='') {
                return City::newInstance()->listAll() ;
            } else {
                return City::newInstance()->listWhere("fk_i_region_id = %d", $region);
            }
        }
    }
    
    function osc_search_url($params = null) {
        $url = osc_base_url(true) . '?page=search';
        if($params!=null) {
            foreach($params as $k => $v) {
                $url .= "&" . $k . "=" . $v;
            }
        }
        return $url;
    }
    
    function osc_search_list_countries() {
        return Search::newInstance()->listCountries();
    }
    
    function osc_search_list_regions($country = '%%%%') {
        return Search::newInstance()->listRegions($country);
    }
    
    function osc_search_list_cities($region = '%%%%') {
        return Search::newInstance()->listCities($region);
    }
    

    
    
?>
