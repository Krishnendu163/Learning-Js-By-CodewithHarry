------------
ACF Repeater Code
------------
<?php if(have_rows('tailored_usp')):?>
    <ul>
        <?php while( have_rows('tailored_usp')) : the_row();?>        
            <li>
                <h2><?php the_sub_field('tailrd_usp_title')?></h2>
                <h3><?php the_sub_field('tailrd_usp_subtitle')?></h3>
                <p><?php the_sub_field('tailrd_usp_paragraph')?></p>
            </li>
        <?php endwhile;?>                              
    </ul>
<?php endif?>

------------
lINK field dynamic Code
------------
<?php 
$showcase_btn = get_field('showcase_interested_button');
if( $showcase_btn ): 
    $link_url = $showcase_btn['url'];
    $link_title = $showcase_btn['title'];
    $link_target = $showcase_btn['target'] ? $showcase_btn['target'] : '_self';
    ?>
    <a class="btn cmn_black_stroke" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
<?php endif; ?>

------------
Template path get Code
------------
<img  src="<?php echo get_template_directory_uri() ?> . '/assets/images/arrow_right.svg'"  alt="icon">


------------
Image + Alt Dynamic Code
------------
 <!-- $size = 'large';    -->
<?php 
$imagesT = get_field('text_area_image'); //'Get Filed' For main field 

//OR

$imagesT = get_sub_field('text_area_image');  
if( $imagesT ) { echo wp_get_attachment_image( $imagesT, 'full');}

?>     


------------
ACF Repeater With first item add class Code
------------
<?php if(have_rows('why_choose_us_repeater')):
    $count = 0; 
        while( have_rows('why_choose_us_repeater')) : the_row();?>   
        <div class="accrdn_item">
            <div class="title">
                <?php echo get_sub_field('why_choose_accordian_title')?>
            </div>
            <div class="desc"  <?php if (!$count) {?> style="display:block"; <?php }?> >
                <?php echo get_sub_field('why_choose_accordian_descriptions')?>
            </div>
        </div>
        <?php $count++;
        endwhile;                               
endif?>

------------
While Loop Code
------------
<?php
    if(have_posts())
        while(have_posts()){
             the_post();?>

        <li></li>

<?php } ?>

------------
Post type Loop Code
------------
<?php 
    $wpnews=array(
        'post_type'=>'news',
        'post_status'=>'publish',
        'order' => 'ASC'
    );

    $newsquery=new Wp_Query($wpnews);
    while($newsquery->have_posts()){
            $newsquery->the_post();
    ?>


    <?php } ?>
<?php wp_reset_query() ?>

------------
Feature Image + title + date Code
------------
<?php the_post_thumbnail("new_thumb")?>
<div class="team_items_white_box">
    <h3><?php the_title()?></h3>
    <h4><?php echo get_the_date()?></h4> <!-- this returns >> February 27 2024-->
    <!-- or -->
    <?php echo get_the_date('n.j.y'); ?><!-- And this returns >> 2.27.24-->
    <a href="<?php echo the_permalink()?>" class="btn cmn_black_stroke">Read More</a>                                
</div>
 

------------
main category get Code
------------
<ul class="cmn_arrow_hover">
    <?php 
    $newscat_args = array(
        'taxonomy' => 'category',
        'hide_empty' => false,
        'parent' => 0,
    );

    $newscat = get_terms($newscat_args);

    foreach ($newscat as $newscateData) {
    ?>
    <li>                        
        <a href="<?php echo get_category_link($newscateData->term_id)?>">
            <?php echo $newscateData->name; ?>
            <img src="<?php echo get_template_directory_uri()?>/assets/images/arrow_right.svg" alt="Arrow Icon"/>
        </a>
    </li> 
    <?php } ?>
</ul>

------------
Parent post type category get Code
------------
<?php 
    $newscat = get_the_category(); // Get the categories for the current post

    foreach ($newscat as $category) {
?>
    <h4><?php echo $category->name; ?></h4>
<?php } ?>

------------
First parent and then his subcategory and order them customely get Code
------------
<!-- Step one -->
<ul>
    <?php
    $maincat_args = array(
        'taxonomy' => 'category',
        'hide_empty' => false,
        'parent' => 0,
        'meta_key' => 'category_order', // Custom order field name
        'orderby' => 'meta_value_num', // Order by numeric value
        'order' => 'ASC', // ASC for ascending order, DESC for descending order
    );

    $maincats = get_terms($maincat_args);

    foreach ($maincats as $maincatData) {
        ?>
        <li>                        
            <a href="<?php echo get_category_link($maincatData->term_id)?>">
                <?php echo $maincatData->name; ?>
                    
            </a>

            <?php
            // Get subcategories for the current main category
            $subcat_args = array(
                'taxonomy' => 'category',
                'hide_empty' => false,
                'parent' => $maincatData->term_id,
            );

            $subcats = get_terms($subcat_args);

            if (!empty($subcats)) {
                ?>
                <ul class="subcategories cmn_arrow_hover">
                    <?php
                    foreach ($subcats as $subcatData) {
                        ?>
                        <li class="subcat_item">
                            <a href="<?php echo get_category_link($subcatData->term_id)?>">
                                <?php echo $subcatData->name; ?>
                                    <img src="<?php echo get_template_directory_uri()?>/assets/images/arrow_right.svg" alt="Arrow Icon"/>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </li> 
        <?php
    }
    ?>
</ul>
<!-- Step Two -->
A. In the WordPress admin, go to Custom Fields > Add New.
B. Create a new field group for categories with a field named "category_order" (type: Number).
C. Assign this field group to the "category" taxonomy.

------------
post by category function Code
------------
<?php 
$newscat = get_terms([
    'taxonomy'=>'news_category',
    'hide_empty'=>false
        
    ] );

    foreach ($newscat as $newscateData){
?>
<h3>
    <a href="<?php echo get_category_link($newscateData->term_id)?>">
        <?php echo $newscateData->name; ?>
    </a>
</h3>

<!-- category post get function -->
<div class="srvcs_lstng">
    <ul>   
        <?php 
            $wpnews=array(
                'post_type'=>'news',
                'post_status'=>'publish',
                'order' => 'ASC',
                'tax_query' => array(
                [
                    'taxonomy' => 'news_category',
                    'field' => 'term_id',
                    'terms' => $newscateData->term_id
                    ]
                )
            );

            $newsquery=new Wp_Query($wpnews);
            while($newsquery->have_posts()){
                    $newsquery->the_post();
            ?>
                <li>
                    <div class="d_flex">
                        <div class="col_50 srvcs_lstng_text">
                                <h2><?php the_title()?></h2>
                                <div> <?php //the_content()?></div>
                                <a href="<?php echo the_permalink()?>"  class="btn bg_white cmn_btn_blue" >Read More</a
                                >
                        </div>
                        <div class="col_50 srvcs_lstng_img">
                                <?php the_post_thumbnail("new_thumb")?>
                        </div>
                    </div>
                    <div class="srvcs_lstng_icon"><?php echo get_the_date()?></div>
                </li>

        <?php }?>
            <?php wp_reset_query() ?>

        
    </ul>
</div>
<?php }?>
<?php wp_reset_query() ?>

------------
ACF Gallery Field Code
------------
<?php if($images):?>
    <?php foreach($images as $image):?>
        <img src="<?php echo $image;?>">
    <?php endforeach?>
<?php endif?>

------------
Flexible Content Loop  Code
------------
<?php if(have_rows('flxble_cntnt')):?>    
    <?php while( have_rows('flxble_cntnt')) : the_row();?>
        <!-- First Loop -->
        <?php if(get_row_layout() == 'text_group'):?>
            <h3><?php the_sub_field('text_title');?></h3>
            <p><?php the_sub_field('text_paragraph');?></p>
        <?php endif?>
        
        <!-- Second Loop -->
        <?php if(get_row_layout() == 'image_with_text'):
            $imagesT = get_sub_field('text_area_image');
            $size = 'large';                         
        ?>

            <h3><?php the_sub_field('image_text');?></h3>
            <?php if( $imagesT ) { echo wp_get_attachment_image( $imagesT, $size);}?>      
        <?php endif?>

    <?php endwhile?>
<?php endif?>

------------
CSS and JS Adding Functions file Code
------------
<?php 
    
//Adding Css
function velricon_css() {
    wp_enqueue_style( 'fontCss', get_template_directory_uri() . '/css/font.min.css', false, null, 'all' );
    wp_enqueue_style( 'homeCss', get_template_directory_uri() . '/css/home.css', false, null, 'all' );
    wp_enqueue_style( 'aboutCss', get_template_directory_uri() . '/css/about.css', false, null, 'all' );
    wp_enqueue_style( 'servcsLstng', get_template_directory_uri() . '/css/services_listing.css', false, null, 'all' );
    wp_enqueue_style( 'servcsDtls', get_template_directory_uri() . '/css/services_details.css', false, null, 'all' );

}
add_action( 'wp_enqueue_scripts', 'velricon_css' );

//Adding JS
function velricon_scripts() {
    wp_enqueue_script('jquery');
    // wp_register_script( 'jqueryMinJs', get_template_directory_uri() . '/js/jquery-3.4.1.min.js', array(), '1.0.1', 'all' );
    wp_register_script( 'mainJs', get_template_directory_uri() . '/js/main.js', false, null, 'all');
    wp_enqueue_script('mainJs');
}
add_action( 'wp_enqueue_scripts', 'velricon_scripts' );

?>

------------
Option page get field Code
------------
<?php echo get_field('fter_scal_link', 'option');?>


------------
Standard  get Field Code
------------
<?php echo get_field('home_banner_title');?>

------------
Repeater With First Element Modify Code
------------
<div class="d_flex">
    <div class="col_30">
    <?php if (have_rows('menu_items','option')) : ?>
        <ul>
            <?php $first_iteration = true; ?>
            <?php while (have_rows('menu_items','option')) : the_row(); ?>
                <li>
                    <?php if (!$first_iteration) : ?>
                        <a href="<?php echo the_sub_field('menu_items_links','option')?>">
                    <?php endif; ?>
                    <?php if ($first_iteration) : ?>
                        <h2><?php echo the_sub_field('menu_text','option')?></h2>
                        <?php 
                            $menu_top_btn = get_sub_field('menu_top_btn');
                            if( $menu_top_btn ): 
                                $link_url = $menu_top_btn['url'];
                                $link_title = $menu_top_btn['title'];
                                $link_target = $menu_top_btn['target'] ? $menu_top_btn['target'] : '_self';
                                ?>
                            <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>" class="btn cmn_grey_stroke">
                                <?php echo esc_html( $link_title ); ?>
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <h3><?php echo the_sub_field('menu_text','option')?></h3>
                    <?php endif; ?>
                    <?php if ($first_iteration) : ?>
                        <?php else : ?>
                            <h4><?php echo the_sub_field('menu_designation','option')?></h4>
                    <?php endif; ?>
                    </a>
                </li>
                <?php $first_iteration = false; ?>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
    </div>
</div>
------------
Break Ul Li after any number Code
------------
<?php $wpnews=array(
        'post_type'=>'services',
        'post_status'=>'publish',
        'order' => 'ASC'
    ); 

    $newsquery=new Wp_Query($wpnews);
    $k = 0;
    if(have_posts())
    while($newsquery->have_posts()){
            $newsquery->the_post();
            $k++;
    ?>      
    <li>
        <div>
            <?php 
                $what_we_offer_left_img = get_field('what_offer_left_row_img');
                if( $what_we_offer_left_img ) { echo wp_get_attachment_image( $what_we_offer_left_img, 'auto');}
            ?>      
        </div>
        <div class="what_we_usp_tx">                                         
            <h2><?php the_title() ?></h2>
            <?php the_content()?>
                                    
        </div>
    </li>
    
    <?php 
        if($k % 4 == 0  &&  $k != $newsquery->post_count){
            echo '</ul></div><div class="what_we_usp_item"><ul>';
        }
        ?>
    <?php } ?>
<?php wp_reset_query() ?>

------------
Relation Field Code
------------
<?php
$featured_posts = get_field('featured_posts');
if( $featured_posts ): ?>
    <ul>
    <?php foreach( $featured_posts as $post ): 

        // Setup this post for WP functions (variable must be named $post).
        setup_postdata($post); ?>
        <li>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            <span>A custom field from this post: <?php the_field( 'field_name' ); ?></span>
        </li>
    <?php endforeach; ?>
    </ul>
    <?php 
    // Reset the global post object so that the rest of the page works correctly.
    wp_reset_postdata(); ?>
<?php endif; ?>

------------
Relation Field with post count and brekable eliment Code
------------
<?php
$featured_posts = get_field('all_services');
    $movie_count = count(get_field('all_services'));
if( $featured_posts ): ?>
    <ul>
    <?php 
        $m = 0;
        foreach( $featured_posts as $post ): 
        $m++;
        setup_postdata($post); ?>    
        <li>
            <div>
                <?php 
                
                    $varr = get_field('what_offer_left_row_img');
                    if( $varr ) { echo wp_get_attachment_image( $varr, 'auto');}
                ?>      
            </div>
            <div class="what_we_usp_tx">                                         
                <h2><?php the_title() ?></h2>
                <?php the_excerpt()?>
                <a href="<?php echo the_permalink()?>">
                    <?php echo get_field('srvcs_lstng_text_btn')?>
                </a  >
                                        
            </div>
        </li>    
        <?php 
            if($m % 4 == 0  &&  $m != $movie_count){
                echo '</ul></div><div class="what_we_usp_item"><ul>';
            }
        ?>                                
    <?php endforeach; ?>
    
    <?php  wp_reset_postdata(); ?>
<?php endif; ?>

------------
wp_title Code
------------
<title>
    <?php bloginfo('name'); ?> 
    <?php if(is_front_page()){
        echo '| ', bloginfo('description') ;
    }?> 
    <?php wp_title('»'); ?>
</title>

------------
Custom Post Create Code
------------
<?php function services_custom_post_type() {
	register_post_type('services',
		array(
			'labels'      => array(
				'name'          => __('Services', 'textdomain'),
				'singular_name' => __('Services', 'textdomain'),
			),
            'public'      => true,
            'has_archive' => false,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
            'rewrite' => array('slug' => 'services','with_front' => false),            
		)
	);
    flush_rewrite_rules();
}
add_action('init', 'services_custom_post_type');
?>

------------
Section data checking Code
------------
<?php if(get_field('about_services_btn_url')) { ?><!-- For get_field -->
    
<?php }?>
------------
<?php if(get_sub_field('about_services_btn_url')) { ?><!-- For get_sub_field -->
    
<?php }?>
------------
<?php if(have_rows('adventure_studio_repeater')) { ?><!-- For repeater field -->

<?php }?>
------------
<?php   $title = get_sub_field('accordian_title');
    $descriptions = get_sub_field('accordian_descriptions');

    if ($title && $descriptions ) { ?> <!-- many field data checking -->
<?php }?>


------------
Get year automatically Code
------------
<?php echo date("Y"); ?>

------------
Add a class on header when yuo are on ny specific template Code
------------
<header class="full_width main_header navbar-fixed-top sticky 
<?php echo (is_page_template('services_template.php')) ? 'innerpage' : ''; ?>" id="header">
</header>

------------
Add a taxonomy Code
------------
<?php 
add_action( 'init', 'create_my_taxonomy' );

function create_my_taxonomy(){

	register_taxonomy( 'services_taxonomy', [ 'services' ], [
		'label'                 => '', // Default taken from $labels->name
		// Full list: wp-kama.com/function/get_taxonomy_labels
		'labels'                => [
			'name'              => 'Services Taxonomy',
			'singular_name'     => 'Taxonomy',
			'search_items'      => 'Search Services Taxonomy',
			'all_items'         => 'All Services Taxonomy',
			'view_item '        => 'View Services Taxonomy',
			'parent_item'       => 'Parent Services Taxonomy',
			'parent_item_colon' => 'Parent Services Taxonomy:',
			'edit_item'         => 'Edit Services Taxonomy',
			'update_item'       => 'Update Services Taxonomy',
			'add_new_item'      => 'Add New Services Taxonomy',
			'new_item_name'     => 'New Services Taxonomy Name',
			'menu_name'         => 'Services Taxonomy',
			'back_to_items'     => '← Back to Services Taxonomy',
		],
		'description'           => '',
		'public'                => true,		 
		'hierarchical'          => false,

		'rewrite'               => true,
		'capabilities'          => array(),
		'show_admin_column'     => false, // auto-creation of a posts table column for the associated post type.
		'show_in_rest'          => null, // add to the REST API
		'rest_base'             => null, // $taxonomy
	] );
}
?>


------------
Tab + lightbox dynamic Code
------------
<div>
    <ul class="d_flex" id="portfolio-flters">
        <li data-filter="*" class="filter-active">All</li>
        <?php 
            $newscat = get_terms([
                'taxonomy'=>'services_taxonomy',
                'hide_empty'=>false
                    
                ] );                   
                foreach ($newscat as $newscateData){
            ?>
                
                <li data-filter=".filter-<?php echo $newscateData->name; ?>" class="filter-active">
                    <?php echo $newscateData->name; ?> 
                </li>
        <?php }?>

    </ul>
</div>
<div class="portfolio-container showcase_item_box m_top80">
    <?php 
        $wpnews = array(
            'post_type' => 'services',
            'post_status' => 'publish',
            'order' => 'ASC',                     
        );

        $newsquery = new WP_Query($wpnews);

        while ($newsquery->have_posts()) {
            $newsquery->the_post();
            $terms = get_the_terms(get_the_ID(), 'services_taxonomy');
            
            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
    ?>                     
            <div class="showcse_item portfolio-item filter-<?php echo $term->name; ?>">
                <div class="portfolio-wrap">
                    
                    <?php 
                        $services_img = get_field('services_image');  
                        if( $services_img ) { echo wp_get_attachment_image( $services_img, 'full');}
                    ?>
                    <div class="showcse_item_hover">
                        <h2><?php the_title()?></h2>
                        <a href="<?php echo get_field('services_lightbox_image')?>" data-lightbox="portfolio">
                            <i class="icon-camera medium-icon"></i>
                        </a>  
                        <a href="<?php echo the_permalink()?>">
                            <img src="<?php echo get_template_directory_uri() ?>../assets/images/link.webp" alt="Icon"/>
                        </a>
                    </div>                                                 
                        
                </div>
            </div>
    <?php
            }
        }
    }
    wp_reset_query();
    ?>  
</div>
------------
Progressbar Code
------------
<script>
    (function ($) {
        $(document).ready(function () {
            var docHeight = $(document).height(),
                windowHeight = $(window).height(),
                scrollPercent;

            $(window).scroll(function () {
                scrollPercent =
                    ($(window).scrollTop() / (docHeight - windowHeight)) * 100;

                $(".progressBar").width(scrollPercent + "%");
            });
        });
    })(jQuery);
</script>



------------
Pagination Code  
------------
<!-- First Step in Function.php -->
<script>
    function pagination_bar( $custom_query ) {

        $total_pages = $custom_query->max_num_pages;
        $big = 999999999; // need an unlikely integer

        if ($total_pages > 1){
            $current_page = max(1, get_query_var('paged'));

            echo paginate_links(array(
                'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format' => '?paged=%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'prev_text' => __('পূর্ববর্তী পোস্ট'),
                'next_text' => __('পরবর্তী পোস্ট'),
            ));
        }
    }
</script>

<!-- Second Step in Blog listing template file -->
<div class="team_members blog m_top80">
    <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $loop = new WP_Query( 
            array( 
                'post_type' => 'post',
                'posts_per_page' => 3,
                'order' => 'ASC',
                'paged' => $paged 
                )
        );
            if ( $loop->have_posts() ):
                while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <div class="team_items">
                        <?php the_post_thumbnail("new_thumb")?>
                        <div class="team_items_white_box">
                            <h3><?php the_title()?></h3>
                            <h4><?php echo get_the_date()?></h4>
                            <a href="<?php echo the_permalink()?>" class="btn cmn_black_stroke">Read More</a>                                
                        </div>
                    </div>
                <?php endwhile; ?>                        
    <?php wp_reset_postdata(); endif;?>
</div>
<div class="pagination">
    <?php pagination_bar( $loop ); ?>
</div>

------------
//Theme Option Code
------------
<?php
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Header',
        'menu_title'    => 'Header',
        'parent_slug'   => 'header',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Footer',
        'menu_title'    => 'Footer',
        'parent_slug'   => 'footer',
    ));

}
?>

------------
Theme Logo Code
------------
<?php 
    if(has_custom_logo()){
        the_custom_logo();
    }
?>

------------
Ajax Filter Code Step by Step
------------
<!-------------- First Step is we need to create a custom-script.js file -------------->
<!-------------- First Step is we need to create a custom-script.js file -------------->
<script>
    // (function ($) {
    jQuery(function ($) {
        $(".get_services li").on("click", function () {
            var cat = $(this).text(); // Assuming you want the text of the clicked li
            // alert(cat);
            var data = {
                action: "filter_posts",
                cat: cat,
            };
            $.ajax({
                url: variables.ajax_url, // Assuming variables is a defined object
                type: "POST",
                data: data, // Fix: pass the 'data' variable, not the string "data"
                success: function (response) {
                    $(".showcase_item_box").html(response);
                },
            });
        });
    });
    // })(jQuery)
</script>


<!-------------- Second Step in Function.php || We need to add the file --------------->
<!-------------- Second Step in Function.php || We need to add the file --------------->
<?php
function Ajax_scripts() {
    // Enqueue the script
    wp_enqueue_script('custom_scripts', get_template_directory_uri() . '/assets/js/custom-scripts.js', false, null, 'all');
    // Localize script variables
    wp_localize_script('custom_scripts', 'variables', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
}
add_action( 'wp_enqueue_scripts', 'Ajax_scripts' );
?>

<!-------------------------- Third Step Also in Function.php -------------------------->
<!-------------------------- Third Step Also in Function.php -------------------------->
<?php 
// Ajax tab 
add_action('wp_ajax_filter_posts', 'filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts');

function filter_posts() {
    $args = array(
        'post_type' => 'services',
        'posts_per_page' => -1,
    );

    $type = isset($_REQUEST['cat']) ? $_REQUEST['cat'] : '';

    if (!empty($type)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'services_taxonomy',
                'field'    => 'slug', // Change to 'slug' if using term slug
                'terms'    => $type,
            ),
        );
    }

    $movies = new WP_Query($args);

    if ($movies->have_posts()) {
        while ($movies->have_posts()) : $movies->the_post();
            get_template_part('templates-parts/loop', 'movie');
        endwhile;
        wp_reset_postdata();
    } else {
        echo "Post Not Found";
    }

    wp_die();
}
?>
<!-------------------- Fourth Step in Our home_template.php file ---------------------->
<!-------------------- Fourth Step in Our home_template.php file ---------------------->
<div>
<ul class="d_flex get_services">
    <!-- By this code we show the category \/-->
    <?php 
        $newscat = get_terms([
            'taxonomy' => 'services_taxonomy',
            'hide_empty' => false
        ]);

        foreach ($newscat as $newscateData) {
            echo '<li>' . esc_html($newscateData->name) . '</li>';
        }
    ?>
</ul>

    <!-- By this code we show the post \/-->
<?php 
    $args = [
        'post_type' => 'services',
        'posts_per_page' => -1,
    ];

    $movies = new WP_Query($args);  ?>
    <div class="showcase_item_box m_top80">
    <?php while ($movies->have_posts()) {
        $movies->the_post(); 
    ?>
        <!-- Here we use a common use loop file \/-->
        <?php get_template_part('templates-parts/loop', 'movie') ?>
        <?php  }  wp_reset_postdata(); ?>
    </div>
</div>

<!------ last Step is we need to create the loop-movie file under the template parts folder ----->
<!------ last Step is we need to create the loop-movie file under the template parts folder ----->
<div class="showcse_item">
    <div class="portfolio-wrap">
        
        <?php 
            $services_img = get_field('services_image');  
            if( $services_img ) { echo wp_get_attachment_image( $services_img, 'full');}
        ?>
        <div class="showcse_item_hover">
            <h2><?php the_title()?></h2>
            <a href="<?php echo get_field('services_lightbox_image')?>" data-lightbox="portfolio">
                <i class="icon-camera medium-icon"></i>
            </a>  
            <a href="<?php echo the_permalink()?>">
                <img src="<?php echo get_template_directory_uri() ?>../assets/images/link.webp" alt="Icon"/>
            </a>
        </div>                                                 
        
    </div>
</div>

------------
Custom Accordian Code
------------
<!-- html >>> -->
<div class="why_chs_accordian wrapper">
    <div class="accrdn_item">
        <div class="title">
            Title 1
        </div>
        <div class="desc"> 
            Descriptions
        </div>
    </div>

    <div class="accrdn_item">
        <div class="title">
            Title 1
        </div>
        <div class="desc"> 
            Descriptions
        </div>
    </div>
    
    <div class="accrdn_item">
        <div class="title">
            Title 1
        </div>
        <div class="desc"> 
            Descriptions
        </div>
    </div>
</div>

<!-- JS >>> -->
<script>
    $(document).ready(function () {
        $(".accrdn_item:first").attr("id", "displayed");
        $(".accrdn_item:first").children().last().slideDown(100);
        $(".accrdn_item:first").find("#closed").css("display", "none");
        $(".accrdn_item:first")
            .children()
            .first()
            .children()
            .last()
            .addClass("clicked");
    });

    function accordion() {
        if ($(this).attr("id") !== "displayed") {
            $(".accrdn_item").removeAttr("id");
            $(".accrdn_item").find("#closed").css("display", "initial");
            $(".desc").slideUp(300);

            $(this).attr("id", "displayed");
            $(this).children().last().slideDown(300);

            var closed = $(this).find("#closed");
            closed.css("display", "none");
            $(this)
                .children()
                .first()
                .children()
                .last()
                .attr("class", "clicked");
        } else {
            $(this).removeAttr("id");
            $(this).children().last().slideUp(300);
            var closed = $(this).find("#closed");
            closed.css("display", "initial");
        }
    }
    $(".accrdn_item").on("click", accordion);
</script>


------------
Blog's default Image Code
------------
<script>
function wpse55748_filter_post_thumbnail_html( $html ) {
    // If there is no post thumbnail,
    // Return a default image
    if ( '' == $html ) {
        return '<img src="' . get_template_directory_uri() . '/assets/images/noimg.jpg" width="640" height="426"/>';
    }
    // Else, return the post thumbnail
    return $html;
}
add_filter( 'post_thumbnail_html', 'wpse55748_filter_post_thumbnail_html' )

</script>


------------
Slick Counter Code
------------
<script>
$(document).ready(function () {
    var totalSlides; // Declare a global variable

    $(".regular").on(
        "init reInit afterChange",
        function (event, slick, currentSlide) {
            var slideNumber = currentSlide + 1;
            totalSlides = slick.slideCount;
            $(".news__counter").html(slideNumber + "/" + totalSlides);
        }
    );

    $(window).on("load", function () {
        $(".news__counter").html("1/" + totalSlides);
    });

    $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        lazyLoad: "ondemand",
        arrows: true,
        fade: true,
        nextArrow: ".next",
        prevArrow: ".previous",
    });
});
</script>

------------
progress bar increses height by scroll Code
------------
<script>
jQuery(document).ready(function ($) {
        var docHeight = $(document).height(),
            windowHeight = 600,
            scrollPercent,
            maxScrollPercent = 100; // Set your desired maximum height percentage

        $(window).scroll(function () {
            scrollPercent =
                ($(window).scrollTop() / (docHeight - windowHeight)) * 1000;

            // Limit the scrollPercent to the maximum value
            scrollPercent = Math.min(scrollPercent, maxScrollPercent);

            $(".hgeadbg").height(scrollPercent + "%");

            // Add or remove the class on the header based on the scrollPercent value
            if (scrollPercent >= 40) {
                $("header").addClass("black"); // Replace "your-class-name" with your desired class name
            } else {
                $("header").removeClass("black");
            }
        });
    });
</script>

------------
Video play when open popup and pause when cross the popup
------------
<script>
    (function ($) {
    $(document).ready(function () {
        var video = $("#demoVideo")[0]; // Get the video element

        $(".popup-open").click(function () {
            // Show the popup
            $(".popup-wrap").show();

            // Check if the video is paused, then play it
            if (video.paused) {
                video.play();
            }
        });

        $(".popup-close").click(function () {
            // Check if the video is playing, then pause it

            // Hide the popup
            $(".popup-wrap").hide();
        });

        $("#pauseVideoButton").click(function () {
            // Check if the video is playing, then pause it
            if (!video.paused) {
                video.pause();
            }
        });
    });
})(jQuery);
</script>


------------
Listing posts by acf check field
------------

<?php switch_to_blog(1);?>

<?php 
    $wpnews=array(
        'post_type'=>'partners',
        'post_status'=>'publish',
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'acf_checkbox_field', // Replace with the actual ACF checkbox field key
                'value' => '1', // Assuming 1 is the value when the checkbox is checked
                'compare' => '='
            )
        )
    );

    $newsquery=new WP_Query($wpnews);

    while($newsquery->have_posts()) {
        $newsquery->the_post();
?>
    <div class="team-col">
        <div class="team-blog">
            <?php if(get_field('referrar_image_url')): ?> 
                <a href="<?php the_permalink()?>" class="url" target="_blank">
                    <div class="team-img">
                        <img src="<?php echo get_field('referrar_image_url')?>" alt="">             
                    </div>
                </a>
            <?php endif; ?>
            
            <div class="team-details">
                <h5><?php the_title()?></h5>
            </div>

            <a href="<?php the_permalink()?>" class="url" target="_blank">
                See More
            </a>
        </div>
    </div>         
<?php } ?>

<?php wp_reset_query() ?>

------------
Popup will not display after onetime closed by cookie code
------------
<?php 
    if(get_field('popup_switch', 'option') == 1 && get_field('popup_text', 'option')):
    if (!isset($_COOKIE['popup_closed'])):
?>
    <div class="client_offer" id="popUpForm">
        <div id="close">
        </div> 
        <div id="popContainer">
            <?php echo get_field('popup_text','option')?>            
        </div>
</div>
<?php
 endif;
endif;
 ?>