<?php
/**
 * Plugin Name: Bookly pagination-list-service
 * Description: The very first plugin for Bookly Pagination list service
 * Version: 1.0
 * Author: Shobit New
 * Author URI: localhost
 */
function cat_theme_scripts()
{
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_style( 'slider', get_template_directory_uri() . 'assets/css/style.css', array(), '1.1', 'all');
    wp_register_script('custom_script','/wp-content/plugins/bookly-pagination-list-service/assets/js/custom_script.js',);
    wp_register_script( 'custom_script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js', null, null, true );
    wp_enqueue_script('custom_script');
}

add_action('wp_enqueue_scripts', 'cat_theme_scripts');

function service()
{
    global $wpdb;
  $prefix = $wpdb->prefix;
  
  $query = "SELECT {$prefix}bookly_services.category_id,{$prefix}bookly_services.id,{$prefix}bookly_services.title,{$prefix}bookly_services.duration,{$prefix}bookly_services.price,{$prefix}bookly_categories.name FROM {$prefix}bookly_services INNER JOIN {$prefix}bookly_categories ON {$prefix}bookly_services.category_id = {$prefix}bookly_categories .id";
    $html = '';

    // $query = "SELECT wp_bookly_services.category_id,wp_bookly_services.id,wp_bookly_services.title,wp_bookly_services.duration,wp_bookly_services.price,wp_bookly_categories.name FROM wp_bookly_services INNER JOIN wp_bookly_categories ON wp_bookly_services.category_id = wp_bookly_categories .id";

    $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total = $wpdb->get_var($total_query);
    $items_per_page = 4;
    $page = isset($_GET['servicelist']) ? abs((int)$_GET['servicelist']) : 1;
    $offset = ($page * $items_per_page) - $items_per_page;
    $results = $wpdb->get_results($query . " ORDER BY title ASC LIMIT ${offset}, ${items_per_page}");
    $totalPage = ceil($total / $items_per_page);
    if ($totalPage > 1)
    {
        foreach ($results as $row)
        {
            $fldcatid = $row->category_id;
            $fldid = $row->id;
            $fldtitle = $row->title;
            $fldprice = $row->price;
            $fldname = $row->name;

         $html .= '<div class="product_wrapper" style="padding: 5px !important; float:left; text-align: center; width: 12rem; border: 1px solid black; margin-left: 6% !important;">
                    <img src="https://www.bell.ca/Styles/wireless/all_languages/all_regions/catalog_images/Google_Pixel_3a/Google_3a_aka_Sargo_Black_lrg1_en.png">
                    <div class="name"><b> ' . $fldtitle . ' </b></div>
                    <div>SERVICE : ' . $fldname . '</div>
                    <div>PRICE : ' . $fldprice . '</div>  
                    <button class="class_a btn-primary" cat_id="'.$fldcatid.'"id="'.$fldid.'" style="text-transform: uppercase; 
                    height: 40px; width: 100%; box-sizing: border-box; border: transparent; letter-spacing: 0.2em;">Book Now</button>
                    </div>';   
        }

        $html .= '<div style="margin-left: 50%; width:3%;">' . paginate_links(array(
            'base' => add_query_arg('servicelist', '%#%') ,
            'format' => '',
            'prev_text' => __('&laquo;') ,
            'next_text' => __('&raquo;') ,
            'total' => $totalPage,
            'current' => $page
        )) . '</div>';
    }
    return $html;
}
add_shortcode('pagination_list_service', 'service');
