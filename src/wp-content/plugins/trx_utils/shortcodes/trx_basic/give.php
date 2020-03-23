<?php
// Theme init
if (!function_exists('charity_is_hope_give_theme_setup')) {
    add_action('charity_is_hope_action_before_init_theme', 'charity_is_hope_give_theme_setup', 1);
    function charity_is_hope_give_theme_setup()    {
        add_action('charity_is_hope_action_shortcodes_list', 'charity_is_hope_give_reg_shortcodes');
        if (function_exists('charity_is_hope_exists_visual_composer') && charity_is_hope_exists_visual_composer()) {
            add_action('charity_is_hope_action_shortcodes_list_vc', 'charity_is_hope_give_reg_shortcodes_vc');
        }
    }
}


// Shortcodes
//------------------------------------------------------------------------

/*
[trx_give_list ]
*/
if ( !function_exists( 'charity_is_hope_sc_give_list' ) ) {
    function charity_is_hope_sc_give_list($atts, $content=null){
        if (charity_is_hope_in_shortcode_blogger()) return '';
        extract(charity_is_hope_html_decode(shortcode_atts(array(
            // Individual params
            "style" => "excerpt",
            "columns" => 3,
            "cat" => "",
            "ids" => "",
            "count" => 3,
            "offset" => "",
            "orderby" => "date",
            "order" => "asc",
            "title" => "",
            "subtitle" => "",
            "description" => "",
            "link_caption" => esc_html__('More donations', 'trx_utils'),
            "link" => '',
            // Common params
            "id" => "",
            "class" => "",
            "css" => "",
            "top" => "",
            "bottom" => ""
        ), $atts)));

        $post_type = CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS;
        $tax = CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY;
        $output = '';
        $in_shortcode = true;
        if (file_exists($tpl = charity_is_hope_get_file_dir( 'templates/trx_give_list/content-'.$style.'.php' ))) {

            if (empty($id)) $id = "sc_donations_".str_replace('.', '', mt_rand());

            $css .= !empty($top) ? 'margin-top:' . $top : '';
            $css .= !empty($bottom) ? 'margin-bottom:' . $bottom : '';

            $count = max(1, (int) $count);
            $columns = max(1, min(12, (int) $columns));
            if ($count < $columns) $columns = $count;

            $output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
                . ' class="sc_donations'
                . ' sc_donations_style_'.esc_attr($style)
                . (!empty($class) ? ' '.esc_attr($class) : '')
                . '"'
                . ($css!='' ? ' style="'.esc_attr($css).'"' : '')
                . '>'
                . (!empty($subtitle) ? '<h6 class="sc_donations_subtitle sc_item_subtitle">' . trim($subtitle) . '</h6>' : '')
                . (!empty($title) ? '<h2 class="sc_donations_title sc_item_title">' . trim($title) . '</h2>' : '')
                . (!empty($description) ? '<div class="sc_donations_descr sc_item_descr">' . trim($description) . '</div>' : '')
                . ($columns > 1
                    ? '<div class="columns_wrap sc_columns sc_columns_count_' . $columns . '">'
                    : '');

            if (!empty($ids)) {
                $posts = explode(',', $ids);
                $count = count($posts);
                if ($count < $columns) $columns = $count;
            }

            $args = array(
                'post_type' => $post_type,
                'post_status' => 'publish',
                'posts_per_page' => $count,
                'ignore_sticky_posts' => true,
                'order' => $order=='desc' ? 'desc' : 'asc'
            );

            if ($offset > 0 && empty($ids)) {
                $args['offset'] = $offset;
            }

            $args = charity_is_hope_query_add_sort_order($args, $orderby, $order);
            $args = charity_is_hope_query_add_posts_and_cats($args, $ids, $post_type, $cat, $tax);

            $query = new WP_Query( $args );

            while ( $query->have_posts() ) {
                $query->the_post();
                ob_start();
                require $tpl;
                $output .= ob_get_contents();
                ob_end_clean();
            }
            wp_reset_postdata();

            if ($columns > 1) {
                $output .= '</div>';
            }

            $output .=  (!empty($link) ? '<div class="sc_donations_button sc_item_button"><a href="'.esc_url($link).'">'.esc_html($link_caption).'</a></div>' : '')
                . '</div><!-- /.sc_donations -->';
        }

        return apply_filters('charity_is_hope_shortcode_output', $output, 'trx_give_list', $atts, $content);
    }
    charity_is_hope_require_shortcode('trx_give_list', 'charity_is_hope_sc_give_list');
}


// Add sorting parameter in query arguments
if (!function_exists('charity_is_hope_query_add_sort_order')) {
    function charity_is_hope_query_add_sort_order($args, $orderby='date', $order='asc') {
        $q = array();
        $q['order'] = $order;
        if ($orderby == 'comments') {
            $q['orderby'] = 'comment_count';
        } else if ($orderby == 'title' || $orderby == 'alpha') {
            $q['orderby'] = 'title';
        } else if ($orderby == 'rand' || $orderby == 'random')  {
            $q['orderby'] = 'rand';
        } else {
            $q['orderby'] = 'post_date';
        }
        foreach ($q as $mk=>$mv) {
            if (is_array($args))
                $args[$mk] = $mv;
            else
                $args->set($mk, $mv);
        }
        return $args;
    }
}


// Add post type and posts list or categories list in query arguments
if (!function_exists('charity_is_hope_query_add_posts_and_cats')) {
    function charity_is_hope_query_add_posts_and_cats($args, $ids='', $post_type='', $cat='', $taxonomy='') {
        if (!empty($ids)) {
            $args['post_type'] = empty($args['post_type'])
                ? (empty($post_type) ? array('post', 'page') : $post_type)
                : $args['post_type'];
            $args['post__in'] = explode(',', str_replace(' ', '', $ids));
        } else {
            $args['post_type'] = empty($args['post_type'])
                ? (empty($post_type) ? 'post' : $post_type)
                : $args['post_type'];
            $post_type = is_array($args['post_type']) ? $args['post_type'][0] : $args['post_type'];
            if (!empty($cat)) {
                $cats = !is_array($cat) ? explode(',', $cat) : $cat;
                if (empty($taxonomy))
                    $taxonomy = 'category';
                if ($taxonomy == 'category') {				// Add standard categories
                    if (is_array($cats) && count($cats) > 1) {
                        $cats_ids = array();
                        foreach($cats as $c) {
                            $c = trim(chop($c));
                            if (empty($c)) continue;
                            if ((int) $c == 0) {
                                $cat_term = get_term_by( 'slug', $c, $taxonomy, OBJECT);
                                if ($cat_term) $c = $cat_term->term_id;
                            }
                            if ($c==0) continue;
                            $cats_ids[] = (int) $c;
                            $children = get_categories( array(
                                'type'                     => $post_type,
                                'child_of'                 => $c,
                                'hide_empty'               => 0,
                                'hierarchical'             => 0,
                                'taxonomy'                 => $taxonomy,
                                'pad_counts'               => false
                            ));
                            if (is_array($children) && count($children) > 0) {
                                foreach($children as $c) {
                                    if (!in_array((int) $c->term_id, $cats_ids)) $cats_ids[] = (int) $c->term_id;
                                }
                            }
                        }
                        if (count($cats_ids) > 0) {
                            $args['category__in'] = $cats_ids;
                        }
                    } else {
                        if ((int) $cat > 0)
                            $args['cat'] = (int) $cat;
                        else
                            $args['category_name'] = $cat;
                    }
                } else {									// Add custom taxonomies
                    if (!isset($args['tax_query']))
                        $args['tax_query'] = array();
                    $args['tax_query']['relation'] = 'AND';
                    $args['tax_query'][] = array(
                        'taxonomy' => $taxonomy,
                        'include_children' => true,
                        'field'    => (int) $cats[0] > 0 ? 'id' : 'slug',
                        'terms'    => $cats
                    );
                }
            }
        }
        return $args;
    }
}

// ---------------------------------- [/trx_give_list] ---------------------------------------


// Add [trx_give_list] in the VC shortcodes list

//// Add custom post type and/or taxonomies arguments to the query
//if ( !function_exists( 'charity_is_hope_give_query_add_filters' ) ) {
//	//Handler of add_filter('charity_is_hope_filter_query_add_filters',	'charity_is_hope_give_query_add_filters', 9, 2);
//	function charity_is_hope_give_query_add_filters($args, $filter) {
//		if ($filter == 'donations') {
//			$args['post_type'] = CHARITY_IS_HOPE_GIVE_POST_TYPE_LIST;
//		}
//		return $args;
//	}
//}

// Add custom post type to the list
if ( !function_exists( 'charity_is_hope_give_list_post_types' ) ) {
    //Handler of add_filter('charity_is_hope_filter_list_post_types',		'charity_is_hope_give_list_post_types');
    function charity_is_hope_give_list_post_types($list) {
        $list[CHARITY_IS_HOPE_GIVE_POST_TYPE_FORMS] = esc_html__('Give Donation forms', 'trx_utils');
        return $list;
    }
}


// Register shortcode in the shortcodes list
if (!function_exists('charity_is_hope_give_reg_shortcodes')) {
    //Handler of add_filter('charity_is_hope_action_shortcodes_list',	'charity_is_hope_give_reg_shortcodes');
    function charity_is_hope_give_reg_shortcodes() {
        if (charity_is_hope_storage_isset('shortcodes')) {

            $donations_groups = charity_is_hope_get_list_terms(false, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY);

            charity_is_hope_sc_map_before('trx_dropcaps', array(

                // Donations list
                "trx_give_list" => array(
                    "title" => esc_html__("Give donations list", 'trx_utils'),
                    "desc" => esc_html__("Insert Donations list", 'trx_utils'),
                    "decorate" => true,
                    "container" => false,
                    "params" => array(
                        "title" => array(
                            "title" => esc_html__("Title", 'trx_utils'),
                            "desc" => esc_html__("Title for the donations list", 'trx_utils'),
                            "value" => "",
                            "type" => "text"
                        ),
                        "subtitle" => array(
                            "title" => esc_html__("Subtitle", 'trx_utils'),
                            "desc" => esc_html__("Subtitle for the donations list", 'trx_utils'),
                            "value" => "",
                            "type" => "text"
                        ),
                        "description" => array(
                            "title" => esc_html__("Description", 'trx_utils'),
                            "desc" => esc_html__("Short description for the donations list", 'trx_utils'),
                            "value" => "",
                            "type" => "textarea"
                        ),
                        "link" => array(
                            "title" => esc_html__("Button URL", 'trx_utils'),
                            "desc" => esc_html__("Link URL for the button at the bottom of the block", 'trx_utils'),
                            "divider" => true,
                            "value" => "",
                            "type" => "text"
                        ),
                        "link_caption" => array(
                            "title" => esc_html__("Button caption", 'trx_utils'),
                            "desc" => esc_html__("Caption for the button at the bottom of the block", 'trx_utils'),
                            "value" => "",
                            "type" => "text"
                        ),
                        "style" => array(
                            "title" => esc_html__("List style", 'trx_utils'),
                            "desc" => esc_html__("Select style to display donations", 'trx_utils'),
                            "value" => "excerpt",
                            "type" => "select",
                            "options" => array(
                                'excerpt' => esc_html__('Excerpt', 'trx_utils'),
                                'extra' => esc_html__('Extra', 'trx_utils')
                            )
                        ),
                        "readmore" => array(
                            "title" => esc_html__("Read more text", 'trx_utils'),
                            "desc" => esc_html__("Text of the 'Read more' link", 'trx_utils'),
                            "value" => esc_html__('Read more', 'trx_utils'),
                            "type" => "hidden"
                        ),
                        "cat" => array(
                            "title" => esc_html__("Categories", 'trx_utils'),
                            "desc" => esc_html__("Select categories (groups) to show donations. If empty - select donations from any category (group) or from IDs list", 'trx_utils'),
                            "divider" => true,
                            "value" => "",
                            "type" => "select",
                            "style" => "list",
                            "multiple" => true,
                            "options" => charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'trx_utils')), $donations_groups)
                        ),
                        "count" => array(
                            "title" => esc_html__("Number of donations", 'trx_utils'),
                            "desc" => esc_html__("How many donations will be displayed? If used IDs - this parameter ignored.", 'trx_utils'),
                            "value" => 3,
                            "min" => 1,
                            "max" => 100,
                            "type" => "spinner"
                        ),
                        "columns" => array(
                            "title" => esc_html__("Columns", 'trx_utils'),
                            "desc" => esc_html__("How many columns use to show donations list", 'trx_utils'),
                            "value" => 3,
                            "min" => 2,
                            "max" => 6,
                            "step" => 1,
                            "type" => "spinner"
                        ),
                        "offset" => array(
                            "title" => esc_html__("Offset before select posts", 'trx_utils'),
                            "desc" => esc_html__("Skip posts before select next part.", 'trx_utils'),
                            "dependency" => array(
                                'custom' => array('no')
                            ),
                            "value" => 0,
                            "min" => 0,
                            "type" => "spinner"
                        ),
                        "orderby" => array(
                            "title" => esc_html__("Donadions order by", 'trx_utils'),
                            "desc" => esc_html__("Select desired sorting method", 'trx_utils'),
                            "value" => "date",
                            "type" => "select",
                            "options" => charity_is_hope_get_sc_param('sorting')
                        ),
                        "order" => array(
                            "title" => esc_html__("Donations order", 'trx_utils'),
                            "desc" => esc_html__("Select donations order", 'trx_utils'),
                            "value" => "asc",
                            "type" => "switch",
                            "size" => "big",
                            "options" => charity_is_hope_get_sc_param('ordering')
                        ),
                        "ids" => array(
                            "title" => esc_html__("Donations IDs list", 'trx_utils'),
                            "desc" => esc_html__("Comma separated list of donations ID. If set - parameters above are ignored!", 'trx_utils'),
                            "value" => "",
                            "type" => "text"
                        ),
                        //"top" => charity_is_hope_get_sc_param('top'),
                        //"bottom" => charity_is_hope_get_sc_param('bottom'),
                        "id" => charity_is_hope_get_sc_param('id'),
                        "class" => charity_is_hope_get_sc_param('class'),
                        "css" => charity_is_hope_get_sc_param('css')
                    )
                )

            ));
        }
    }
}


// Register shortcode in the VC shortcodes list
if (!function_exists('charity_is_hope_give_reg_shortcodes_vc')) {
    //Handler of add_filter('charity_is_hope_action_shortcodes_list_vc',	'charity_is_hope_give_reg_shortcodes_vc');
    function charity_is_hope_give_reg_shortcodes_vc() {

        $donations_groups = charity_is_hope_get_list_terms(false, CHARITY_IS_HOPE_GIVE_TAXONOMY_CATEGORY);

        // Donations list
        vc_map( array(
            "base" => "trx_give_list",
            "name" => esc_html__("Give Donations list", 'trx_utils'),
            "description" => esc_html__("Insert Donations list", 'trx_utils'),
            "category" => esc_html__('Content', 'trx_utils'),
            'icon' => 'icon_trx_donations_list',
            "class" => "trx_sc_single trx_sc_donations_list",
            "content_element" => true,
            "is_container" => false,
            "show_settings_on_create" => true,
            "params" => array(
                array(
                    "param_name" => "style",
                    "heading" => esc_html__("List style", 'trx_utils'),
                    "description" => esc_html__("Select style to display donations", 'trx_utils'),
                    "class" => "",
                    "value" => array(
                        esc_html__('Excerpt', 'trx_utils') => 'excerpt',
                        esc_html__('Extra', 'trx_utils') => 'extra'
                    ),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "title",
                    "heading" => esc_html__("Title", 'trx_utils'),
                    "description" => esc_html__("Title for the donations form", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "admin_label" => true,
                    "class" => "",
                    "value" => "",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "subtitle",
                    "heading" => esc_html__("Subtitle", 'trx_utils'),
                    "description" => esc_html__("Subtitle for the donations form", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "class" => "",
                    "value" => "",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "description",
                    "heading" => esc_html__("Description", 'trx_utils'),
                    "description" => esc_html__("Description for the donations form", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "class" => "",
                    "value" => "",
                    "type" => "textarea"
                ),
                array(
                    "param_name" => "link",
                    "heading" => esc_html__("Button URL", 'trx_utils'),
                    "description" => esc_html__("Link URL for the button at the bottom of the block", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "class" => "",
                    "value" => "",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "link_caption",
                    "heading" => esc_html__("Button caption", 'trx_utils'),
                    "description" => esc_html__("Caption for the button at the bottom of the block", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "class" => "",
                    "value" => "",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "readmore",
                    "heading" => esc_html__("Read more text", 'trx_utils'),
                    "description" => esc_html__("Text of the 'Read more' link", 'trx_utils'),
                    "group" => esc_html__('Captions', 'trx_utils'),
                    "class" => "",
                    "value" => esc_html__('Read more', 'trx_utils'),
                    "type" => "hidden"
                ),
                array(
                    "param_name" => "cat",
                    "heading" => esc_html__("Categories", 'trx_utils'),
                    "description" => esc_html__("Select category to show donations. If empty - select donations from any category (group) or from IDs list", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "class" => "",
                    "value" => array_flip(charity_is_hope_array_merge(array(0 => esc_html__('- Select category -', 'trx_utils')), $donations_groups)),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "columns",
                    "heading" => esc_html__("Columns", 'trx_utils'),
                    "description" => esc_html__("How many columns use to show donations", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "admin_label" => true,
                    "class" => "",
                    "value" => "3",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "count",
                    "heading" => esc_html__("Number of posts", 'trx_utils'),
                    "description" => esc_html__("How many posts will be displayed? If used IDs - this parameter ignored.", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "class" => "",
                    "value" => "3",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "offset",
                    "heading" => esc_html__("Offset before select posts", 'trx_utils'),
                    "description" => esc_html__("Skip posts before select next part.", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "class" => "",
                    "value" => "0",
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "orderby",
                    "heading" => esc_html__("Post sorting", 'trx_utils'),
                    "description" => esc_html__("Select desired posts sorting method", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "class" => "",
                    "value" => array_flip((array)charity_is_hope_get_sc_param('sorting')),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "order",
                    "heading" => esc_html__("Post order", 'trx_utils'),
                    "description" => esc_html__("Select desired posts order", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    "class" => "",
                    "value" => array_flip((array)charity_is_hope_get_sc_param('ordering')),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "ids",
                    "heading" => esc_html__("client's IDs list", 'trx_utils'),
                    "description" => esc_html__("Comma separated list of donation's ID. If set - parameters above (category, count, order, etc.)  are ignored!", 'trx_utils'),
                    "group" => esc_html__('Query', 'trx_utils'),
                    'dependency' => array(
                        'element' => 'cats',
                        'is_empty' => true
                    ),
                    "class" => "",
                    "value" => "",
                    "type" => "textfield"
                ),

                charity_is_hope_get_vc_param('id'),
                charity_is_hope_get_vc_param('class'),
                charity_is_hope_get_vc_param('css'),
                //charity_is_hope_get_vc_param('margin_top'),
                //charity_is_hope_get_vc_param('margin_bottom')
            )
        ) );

        class WPBakeryShortCode_Trx_Donations_List extends CHARITY_IS_HOPE_VC_ShortCodeSingle {}

    }
}



