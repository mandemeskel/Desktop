<?php
/*
 *  Author: Todd Motto | @toddmotto
 *  URL: html5blank.com | @html5blank
 *  Custom functions, support, custom post types and more.
 */

/*------------------------------------*\
	External Modules/Files
\*------------------------------------*/

// Load any external files you have here

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (!isset($content_width))
{
    $content_width = 900;
}

if (function_exists("add_theme_support"))
{
    // Add Menu Support
    add_theme_support("menus");

    // Add Thumbnail Theme Support
    add_theme_support("post-thumbnails");
    add_image_size("large", 700, "", true); // Large Thumbnail
    add_image_size("medium", 250, "", true); // Medium Thumbnail
    add_image_size("small", 120, "", true); // Small Thumbnail
    add_image_size("custom-size", 700, 200, true); // Custom Thumbnail Size call using the_post_thumbnail("custom-size");

    // Add Support for Custom Backgrounds - Uncomment below if you"re going to use
    /*add_theme_support("custom-background", array(
	"default-color" => "FFF",
	"default-image" => get_template_directory_uri() . "/img/bg.jpg"
    ));*/

    // Add Support for Custom Header - Uncomment below if you"re going to use
    /*add_theme_support("custom-header", array(
	"default-image"			=> get_template_directory_uri() . "/img/headers/default.jpg",
	"header-text"			=> false,
	"default-text-color"		=> "000",
	"width"				=> 1000,
	"height"			=> 198,
	"random-default"		=> false,
	"wp-head-callback"		=> $wphead_cb,
	"admin-head-callback"		=> $adminhead_cb,
	"admin-preview-callback"	=> $adminpreview_cb
    ));*/

    // Enables post and comment RSS feed links to head
    add_theme_support("automatic-feed-links");

    // Localisation Support
    load_theme_textdomain("html5blank", get_template_directory() . "/languages");
}

/*------------------------------------*\
	Functions
\*------------------------------------*/

// HTML5 Blank navigation
function html5blank_nav()
{
	wp_nav_menu(
	array(
		"theme_location"  => "header-menu",
		"menu"            => "",
		"container"       => "div",
		"container_class" => "menu-{menu slug}-container",
		"container_id"    => "",
		"menu_class"      => "menu",
		"menu_id"         => "",
		"echo"            => true,
		"fallback_cb"     => "wp_page_menu",
		"before"          => "",
		"after"           => "",
		"link_before"     => "",
		"link_after"      => "",
		"items_wrap"      => '<ul>%3$s</ul>',
		"depth"           => 0,
		"walker"          => ""
		)
	);
}

// Load HTML5 Blank scripts (header.php)
function html5blank_header_scripts()
{
    if ($GLOBALS["pagenow"] != "wp-login.php" && !is_admin()) {

    	wp_register_script("conditionizr", get_template_directory_uri() . "/js/lib/conditionizr-4.3.0.min.js", array(), "4.3.0"); // Conditionizr
        wp_enqueue_script("conditionizr"); // Enqueue it!

        wp_register_script("modernizr", get_template_directory_uri() . "/js/lib/modernizr-2.7.1.min.js", array(), "2.7.1"); // Modernizr
        wp_enqueue_script("modernizr"); // Enqueue it!

        wp_register_script("html5blankscripts", get_template_directory_uri() . "/js/scripts.js", array("jquery"), "1.0.0"); // Custom scripts
        wp_enqueue_script("html5blankscripts"); // Enqueue it!
    }
}

// Load HTML5 Blank conditional scripts
function html5blank_conditional_scripts()
{
    if (is_page("pagenamehere")) {
        wp_register_script("scriptname", get_template_directory_uri() . "/js/scriptname.js", array("jquery"), "1.0.0"); // Conditional script(s)
        wp_enqueue_script("scriptname"); // Enqueue it!
    }
}

// Load HTML5 Blank styles
function html5blank_styles()
{
    wp_register_style("normalize", get_template_directory_uri() . "/normalize.css", array(), "1.0", "all");
    wp_enqueue_style("normalize"); // Enqueue it!

    wp_register_style("html5blank", get_template_directory_uri() . "/style.css", array(), "1.0", "all");
    wp_enqueue_style("html5blank"); // Enqueue it!
}

// Register HTML5 Blank Navigation
function register_html5_menu()
{
    register_nav_menus(array( // Using array to specify more menus if needed
        "header-menu" => __("Header Menu", "html5blank"), // Main Navigation
        "sidebar-menu" => __("Sidebar Menu", "html5blank"), // Sidebar Navigation
        "extra-menu" => __("Extra Menu", "html5blank") // Extra Navigation if needed (duplicate as many as you need!)
    ));
}

// Remove the <div> surrounding the dynamic navigation to cleanup markup
function my_wp_nav_menu_args($args = "")
{
    $args["container"] = false;
    return $args;
}

// Remove Injected classes, ID"s and Page ID"s from Navigation <li> items
function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : "";
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search("blog", $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// If Dynamic Sidebar Exists
if (function_exists("register_sidebar"))
{
    // Define Sidebar Widget Area 1
    register_sidebar(array(
        "name" => __("Widget Area 1", "html5blank"),
        "description" => __("Description for this widget-area...", "html5blank"),
        "id" => "widget-area-1",
        "before_widget" => '<div id="%1$s" class="%2$s">',
        "after_widget" => "</div>",
        "before_title" => "<h3>",
        "after_title" => "</h3>"
    ));

    // Define Sidebar Widget Area 2
    register_sidebar(array(
        "name" => __("Widget Area 2", "html5blank"),
        "description" => __("Description for this widget-area...", "html5blank"),
        "id" => "widget-area-2",
        "before_widget" => '<div id="%1$s" class="%2$s">',
        "after_widget" => "</div>",
        "before_title" => "<h3>",
        "after_title" => "</h3>"
    ));
}

// Remove wp_head() injected Recent Comment styles
function my_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action("wp_head", array(
        $wp_widget_factory->widgets["WP_Widget_Recent_Comments"],
        "recent_comments_style"
    ));
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function html5wp_pagination()
{
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        "base" => str_replace($big, "%#%", get_pagenum_link($big)),
        "format" => "?paged=%#%",
        "current" => max(1, get_query_var("paged")),
        "total" => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function html5wp_index($length) // Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt("html5wp_index");
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using html5wp_excerpt("html5wp_custom_post");
function html5wp_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function html5wp_excerpt($length_callback = "", $more_callback = "")
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter("excerpt_length", $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter("excerpt_more", $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters("wptexturize", $output);
    $output = apply_filters("convert_chars", $output);
    $output = "<p>" . $output . "</p>";
    echo $output;
}

// Custom View Article link to Post
function html5_blank_view_article($more)
{
    global $post;
    return "... <a class='view-article' href='" . get_permalink($post->ID) . "'>" . __("View Article", "html5blank") . "</a>";
}

// Remove Admin bar
function remove_admin_bar()
{
    return false;
}

// Remove "text/css" from our enqueued stylesheet
function html5_style_remove($tag)
{
    return preg_replace("~\s+type=['\'][^'\']++['\']~", "", $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace("/(width|height)=\'\d*\'\s/", "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function html5blankgravatar ($avatar_defaults)
{
    $myavatar = get_template_directory_uri() . "/img/gravatar.jpg";
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option("thread_comments") == 1)) {
            wp_enqueue_script("comment-reply");
        }
    }
}

// Custom Comments Callback
function html5blankcomments($comment, $args, $depth)
{
	$GLOBALS["comment"] = $comment;
	extract($args, EXTR_SKIP);

	if ( "div" == $args["style"] ) {
		$tag = "div";
		$add_below = "comment";
	} else {
		$tag = "li";
		$add_below = "div-comment";
	}
?>
    <!-- heads up: starting < for the html tag (li or div) in the next line: -->
    <<?php echo $tag ?> <?php comment_class(empty( $args["has_children"] ) ? "" : "parent") ?> id="comment-<?php comment_ID() ?>">
	<?php if ( "div" != $args["style"] ) : ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php endif; ?>
	<div class="comment-author vcard">
	<?php if ($args["avatar_size"] != 0) echo get_avatar( $comment, $args["180"] ); ?>
	<?php printf(__("<cite class='fn'>%s</cite> <span class='says'>says:</span>"), get_comment_author_link()) ?>
	</div>
<?php if ($comment->comment_approved == "0") : ?>
	<em class="comment-awaiting-moderation"><?php _e("Your comment is awaiting moderation.") ?></em>
	<br />
<?php endif; ?>

	<div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
		<?php
			printf( __("%1$s at %2$s"), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__("(Edit)"),"  ","" );
		?>
	</div>

	<?php comment_text() ?>

	<div class="reply">
	<?php comment_reply_link(array_merge( $args, array("add_below" => $add_below, "depth" => $depth, "max_depth" => $args["max_depth"]))) ?>
	</div>
	<?php if ( "div" != $args["style"] ) : ?>
	</div>
	<?php endif; ?>
<?php }

/*------------------------------------*\
	Actions + Filters + ShortCodes
\*------------------------------------*/

// Add Actions
add_action("init", "html5blank_header_scripts"); // Add Custom Scripts to wp_head
add_action("wp_print_scripts", "html5blank_conditional_scripts"); // Add Conditional Page Scripts
add_action("get_header", "enable_threaded_comments"); // Enable Threaded Comments
add_action("wp_enqueue_scripts", "html5blank_styles"); // Add Theme Stylesheet
add_action("init", "register_html5_menu"); // Add HTML5 Blank Menu
// add_action("init", "create_post_type_html5"); // Add our HTML5 Blank Custom Post Type
add_action("widgets_init", "my_remove_recent_comments_style"); // Remove inline Recent Comment Styles from wp_head()
add_action("init", "html5wp_pagination"); // Add our HTML5 Pagination

// Remove Actions
remove_action("wp_head", "feed_links_extra", 3); // Display the links to the extra feeds such as category feeds
remove_action("wp_head", "feed_links", 2); // Display the links to the general feeds: Post and Comment Feed
remove_action("wp_head", "rsd_link"); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action("wp_head", "wlwmanifest_link"); // Display the link to the Windows Live Writer manifest file.
remove_action("wp_head", "index_rel_link"); // Index link
remove_action("wp_head", "parent_post_rel_link", 10, 0); // Prev link
remove_action("wp_head", "start_post_rel_link", 10, 0); // Start link
remove_action("wp_head", "adjacent_posts_rel_link", 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action("wp_head", "wp_generator"); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action("wp_head", "adjacent_posts_rel_link_wp_head", 10, 0);
remove_action("wp_head", "rel_canonical");
remove_action("wp_head", "wp_shortlink_wp_head", 10, 0);

// Add Filters
add_filter("avatar_defaults", "html5blankgravatar"); // Custom Gravatar in Settings > Discussion
add_filter("body_class", "add_slug_to_body_class"); // Add slug to body class (Starkers build)
add_filter("widget_text", "do_shortcode"); // Allow shortcodes in Dynamic Sidebar
add_filter("widget_text", "shortcode_unautop"); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter("wp_nav_menu_args", "my_wp_nav_menu_args"); // Remove surrounding <div> from WP Navigation
// add_filter("nav_menu_css_class", "my_css_attributes_filter", 100, 1); // Remove Navigation <li> injected classes (Commented out by default)
// add_filter("nav_menu_item_id", "my_css_attributes_filter", 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
// add_filter("page_css_class", "my_css_attributes_filter", 100, 1); // Remove Navigation <li> Page ID"s (Commented out by default)
add_filter("the_category", "remove_category_rel_from_category_list"); // Remove invalid rel attribute
add_filter("the_excerpt", "shortcode_unautop"); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter("the_excerpt", "do_shortcode"); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter("excerpt_more", "html5_blank_view_article"); // Add "View Article" button instead of [...] for Excerpts
add_filter("show_admin_bar", "remove_admin_bar"); // Remove Admin bar
add_filter("style_loader_tag", "html5_style_remove"); // Remove "text/css" from enqueued stylesheet
add_filter("post_thumbnail_html", "remove_thumbnail_dimensions", 10); // Remove width and height dynamic attributes to thumbnails
add_filter("image_send_to_editor", "remove_thumbnail_dimensions", 10); // Remove width and height dynamic attributes to post images

// Remove Filters
remove_filter("the_excerpt", "wpautop"); // Remove <p> tags from Excerpt altogether

// Shortcodes
add_shortcode("html5_shortcode_demo", "html5_shortcode_demo"); // You can place [html5_shortcode_demo] in Pages, Posts now.
add_shortcode("html5_shortcode_demo_2", "html5_shortcode_demo_2"); // Place [html5_shortcode_demo_2] in Pages, Posts now.

// Shortcodes above would be nested like this -
// [html5_shortcode_demo] [html5_shortcode_demo_2] Here"s the page title! [/html5_shortcode_demo_2] [/html5_shortcode_demo]



/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/
// TODO: create custom taxonomy, technologies and methods used
// TODO: create custom fields
function create_portfolio_post() {

    // Register Taxonomies for Category
    register_taxonomy_for_object_type( "category", "portfolio" );

    register_taxonomy_for_object_type( "post_tag", "portfolio" );

    // Register Custom Post Type
    register_post_type( "portfolio",
        array(
        "labels" => array(
            "name" => __("Portfolio Posts", "portfolio"),
            "singular_name" => __("Portfolio Post", "portfolio"),
            "add_new" => __("Add New", "portfolio"),
            "add_new_item" => __("Add Portfolio Post", "portfolio"),
            "edit" => __("Edit", "portfolio"),
            "edit_item" => __("Edit Portfolio Post", "portfolio"),
            "new_item" => __("New Portfolio Post", "portfolio"),
            "view" => __("View Portfolio Post", "portfolio"),
            "view_item" => __("View Portfolio Post", "portfolio"),
            "search_items" => __("Search Portfolio Post", "portfolio"),
            "not_found" => __("No Portfolio Posts found", "portfolio"),
            "not_found_in_trash" => __("No Portfolio Posts found in Trash", "html5blank")
        ),
        "public" => true,
        "menu_position" => 6,
        // Allows your posts to behave like Hierarchy Pages
        "hierarchical" => true,
        "has_archive" => true,
        "supports" => array(
            "title",
            "editor",
            "excerpt",
            "thumbnail"
        ),
        // Allows export in Tools > Export
        "can_export" => true,
        // Add Category and Post Tags support
        "taxonomies" => array(
            "post_tag",
            "category"
        )
    ));
}

add_action( "init", "create_portfolio_post" );



/*------------------------------------*\
	ShortCode Functions
\*------------------------------------*/

// Shortcode Demo with Nested Capability
function html5_shortcode_demo($atts, $content = null)
{
    return "<div class='shortcode-demo'>" . do_shortcode($content) . "</div>"; // do_shortcode allows for nested Shortcodes
}

// Shortcode Demo with simple <h2> tag
function html5_shortcode_demo_2($atts, $content = null) // Demo Heading H2 shortcode, allows for nesting within above element. Fully expandable.
{
    return "<h2>" . $content . "</h2>";
}



/*------------------------------------*\
	Theme Options
\*------------------------------------*/
function front_page_customizer_bio_section( $wp_customize ) {

    // TODO: move panel creation out of this function and into a general fnc
    $wp_customize->add_panel( "front_page", array(
        "title" => __( "Front Page" ),
        "description" => "The options to change the front page.",
        "priority" => 16
    ) );

    $wp_customize->add_section( "bio", array(
        "title" => __( "Bio Section" ),
        "panel" => "front_page",
        "priority" => 1
    ) );

    // biography section title
    $wp_customize->add_setting( "front_page_bio_title", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_bio_title", array(
        "label" => __( "Section Title" ),
        "type" => "text",
        "section" => "bio",
        "priority" => 10
    ) );

    // biography image
    $wp_customize->add_setting( "front_page_bio_img", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( new WP_Customize_Media_Control(
        $wp_customize, "front_page_bio_img", array(
            "label" => __( "Bio Image" ),
            "section" => "bio",
            "mime_type" => "image",
            "priority" => 20
        )
    ) );

    // biography image alt text
    $wp_customize->add_setting( "front_page_bio_img_info", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_bio_img_info", array(
        "label" => __( "Bio Image Info" ),
        "type" => "text",
        "section" => "bio",
        "priority" => 30
    ) );

    // biography text
    $wp_customize->add_setting( "front_page_bio_text", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_bio_text", array(
        "label" => __( "Bio Text" ),
        "type" => "textarea",
        "section" => "bio",
        "priority" => 40
    ) );

    // biography color
    $wp_customize->add_setting( "front_page_bio_bgcolor", array(
        "type" => "theme_mod",
        "default" => "#ffffff",
        "transport" => "postMessage",
        "sanitize_callback" => "sanitize_hex_color"
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize, "front_page_bio_bgcolor", array(
            "label" => __( "Background Color" ),
            "section" => "bio",
            "priority" => 50
        )
    ) );

}

add_action( "customize_register", "front_page_customizer_bio_section" );


function front_page_customizer_tools_section( $wp_customize ) {

    $wp_customize->add_section( "tools", array(
        "title" => __( "Tools Section" ),
        "panel" => "front_page",
        "priority" => 2
    ) );

    // tools title
    $wp_customize->add_setting( "front_page_tools_title", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_tools_title", array(
        "label" => __( "Section Title" ),
        "type" => "text",
        "section" => "tools",
        "priority" => 10
    ) );

    // tools title
    $wp_customize->add_setting( "front_page_tools_text", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_tools_text", array(
        "label" => __( "Section Text" ),
        "type" => "textarea",
        "section" => "tools",
        "priority" => 20
    ) );

    // tools color
    $wp_customize->add_setting( "front_page_tools_bgcolor", array(
        "type" => "theme_mod",
        "default" => "#ffffff",
        "transport" => "postMessage",
        "sanitize_callback" => "sanitize_hex_color"
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize, "front_page_tools_bgcolor", array(
            "label" => __( "Background Color" ),
            "section" => "tools",
            "priority" => 30
        )
    ) );

}

add_action( "customize_register", "front_page_customizer_tools_section" );


function front_page_customizer_portfolio_section( $wp_customize ) {

    $wp_customize->add_section( "portfolio", array(
        "title" => __( "Portfolio Section" ),
        "panel" => "front_page",
        "priority" => 3
    ) );

    // section title
    $wp_customize->add_setting( "front_page_portfolio_title", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_portfolio_title", array(
        "label" => __( "Section Title" ),
        "type" => "text",
        "section" => "portfolio",
        "priority" => 10
    ) );

    // tools title
    $wp_customize->add_setting( "front_page_portfolio_text", array(
        "type" => "theme_mod",
        "default" => "",
        "transport" => "postMessage"
    ) );
    $wp_customize->add_control( "front_page_portfolio_text", array(
        "label" => __( "Section Text" ),
        "type" => "textarea",
        "section" => "portfolio",
        "priority" => 20
    ) );

    // section color
    $wp_customize->add_setting( "front_page_portfolio_bgcolor", array(
        "type" => "theme_mod",
        "default" => "#ffffff",
        "transport" => "postMessage",
        "sanitize_callback" => "sanitize_hex_color"
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control(
        $wp_customize, "front_page_portfolio_bgcolor", array(
            "label" => __( "Background Color" ),
            "section" => "portfolio",
            "priority" => 30
        )
    ) );

    // section link
    $wp_customize->add_setting( "front_page_portfolio_link", array(
        "type" => "theme_mod",
        "default" => "#",
        "transport" => "postMessage",
        "sanitize_callback" => "esc_url_raw"
    ) );
    $wp_customize->add_control( "front_page_portfolio_link", array(
        "label" => __( "Link" ),
        "type" => "url",
        "section" => "portfolio",
        "priority" => 40
    ) );

    // number items to display in the portfolio section
    $wp_customize->add_setting( "front_page_portfolio_items", array(
        "type" => "theme_mod",
        "default" => 5,
        "transport" => "postMessage",
        "sanitize_callback" => "esc_url_raw"
    ) );
    $wp_customize->add_control( "front_page_portfolio_items", array(
        "label" => __( "Link" ),
        "type" => "number",
        "section" => "portfolio",
        "priority" => 50
    ) );

}

add_action( "customize_register", "front_page_customizer_portfolio_section" );



/*------------------------------------*\
	Theme Widgets and Widget Areas
\*------------------------------------*/
function front_page_widget_areas() {

    register_sidebar( array(
        "name" => "Front Page Tools Section",
        "id" => "front_page_tools_sidebar",
        "before_widget" => "<div>",
        "after_widget" => "</div>"
    ) );

}

add_action( "widgets_init", "front_page_widget_areas" );


class Tools_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            "tools_widget",
            "Tools Widget",
            array(
                "description" => __( "Create tools for tools section in front page." )
            )
        );

    }

    public function widget( $args, $instance ) {

        extract( $args );

        $title = $instance[ "title" ];
        $image = $instance[ "image" ];
        $link = $instance[ "link" ];

        echo $before_widget;

        ?>

        <div class="tools-widget">
            <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>">
            <label><?php echo $title; ?></label>
            <a href="<?php echo $link; ?>"></a>
        </div>

        <?php

        echo $after_widget;

    }

    public function form( $instance ) {

        if( isset( $instance[ "title" ] ) )
            $title = $instance[ "title" ];
        else
            $title = __( "New title", "text_domain" );


        if( isset( $instance[ "image" ] ) )
            $image = $instance[ "image" ];
        else
            $image = "http://php.net/";


        if( isset( $instance[ "link" ] ) )
            $link = $instance[ "link" ];
        else
            $link = "http://php.net/";

        ?>
        <!-- tool"s title -->
        <p>
            <label for="<?php echo $this->get_field_name( "title" ); ?>">
                <?php _e( "Title:" ); ?>
            </label>
            <input class="widefat"
                id="<?php echo $this->get_field_id( "title" ); ?>"
                name="<?php echo $this->get_field_name( "title" ); ?>"
                type="text"
                value="<?php echo esc_attr( $title ); ?>"
            />
        </p>

        <!-- tool"s image -->
        <p>
            <label for="<?php echo $this->get_field_name( "image" ); ?>">
                <?php _e( "Image URL:" ); ?>
            </label>
            <input class="widefat"
                id="<?php echo $this->get_field_id( "image" ); ?>"
                name="<?php echo $this->get_field_name( "image" ); ?>"
                type="url"
                value="<?php echo esc_attr( $image ); ?>"
            />
        </p>

        <!-- tool"s link -->
        <p>
            <label for="<?php echo $this->get_field_name( "link" ); ?>">
                <?php _e( "Link:" ); ?>
            </label>
            <input class="widefat"
                id="<?php echo $this->get_field_id( "link" ); ?>"
                name="<?php echo $this->get_field_name( "link" ); ?>"
                type="url"
                value="<?php echo esc_attr( $link ); ?>"
            />
        </p>

        <?php

    }

    public function update( $new_instance, $old_instance ) {

        $instance = array();

        $instance[ "title" ] = ( !empty( $new_instance[ "title" ] ) ) ?
            strip_tags( $new_instance[ "title" ] ) : "";

        $instance[ "image" ] = ( !empty( $new_instance[ "image" ] ) ) ?
            strip_tags( $new_instance[ "image" ] ) : "";

        $instance[ "link" ] = ( !empty( $new_instance[ "link" ] ) ) ?
            strip_tags( $new_instance[ "link" ] ) : "";

        return $instance;

    }

}

add_action( "widgets_init", function() { register_widget( "Tools_Widget" ); } );



/*------------------------------------*\
	MISC. Functions
\*------------------------------------*/
function getFeaturedImgSrc( $post_id ) {

   if( !has_post_thumbnail( $post_id ) ) return "";

   $image_src = wp_get_attachment_image_src(
       get_post_thumbnail_id( $post_id ),
       'single-post-thumbnail'
   );

   if( sizeof( $image_src ) > 0 )

       return $image_src[0];

   else

       return "";

}

?>
