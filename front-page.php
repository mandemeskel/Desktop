<?php
/**
 * The home page, fonr-page.php forces wordpress to display this page
 * no matter what option the user selects.
 */
?>

<?php get_header(); ?>

<!-- landing -->
<div class="landing sunny_day row">

    <button id="toggle_nav"></button>

    <!-- msg -->
    <div class="landing_msg">
        <h1> <?php bloginfo( 'name' ); ?> </h1>
        <h2> <?php bloginfo( 'description' ); ?> </h2>
    </div>

    <!-- background img -->
    <img id="waves" src="<?php echo get_template_directory_uri(); ?>/img/waves_croped.png" alt="ocean waves" />

</div>
<!-- /landing -->


<main role="main" class="row">

    <!-- latest post ticker -->
    <?php if (have_posts()): ?>

        <div id="post_ticker" class="col-xs-12">

        <?php while (have_posts()) : the_post(); ?>

            <div id="post-ticker-<?php the_ID(); ?>" class="col-xs-12 col-md-4 post-ticker">

                <a href="<?= get_permalink(); ?>">
                    <?= get_the_title(); ?>
                </a>

            </div>

        <?php endwhile; ?>

        </div>

    <?php endif; ?>
    <!-- /latest post ticker -->



    <!-- dynamic sections -->
    <?php
        $query_args = array(
            "post_type" => "section",
            "tax_query" => array(
                "taxonomy" => "section_page",
                "field" => "slug",
                "terms" => "home"
            )
        );

        $results = new WP_Query( $query_args );

        while( $results->have_posts() ):
            $results->the_post();
            $permalink = get_permalink();
            $title = get_the_title();
    ?>

    <div id="<?php echo $title; ?>" class="col-xs-12 front_page_section" style="background-color: <?php echo "grey"; ?>;">

        <div class="section_content_wrapper col-xs-12">

            <h2 class="section_title">
                <?php echo $title; ?>
            </h2>

            <div class="col-xs-12">
                <?php the_content(); ?>
            </div>

        </div>

    </div>

    <?php
        endwhile;
    ?>
    <!-- /dyanmic sections-->



    <!-- bio -->
    <?php
        $bio_title = get_theme_mod( "front_page_bio_title" );
        $bio_bgcolor = get_theme_mod( "front_page_bio_bgcolor" );
        $bio_img = wp_get_attachment_image_src( get_theme_mod( "front_page_bio_img" ), "original" )[0];
        $bio_img_info = get_theme_mod( "front_page_bio_img_info" );
        $bio_text = get_theme_mod( "front_page_bio_text", "Hello world!" );
    ?>
    <div id="bio" class="col-xs-12 front_page_section" style="background-color: <?php echo $bio_bgcolor; ?>;">

        <div class="section_content_wrapper col-sm-12 col-md-6">

            <h2 class="section_title">
                <?php echo $bio_title; ?>
            </h2>

            <p>
                <img class="headshot" src="<?php echo $bio_img; ?>"
                                    alt="<?php echo $bio_img_info; ?>"/>
                <?php echo $bio_text; ?>
            </p>

        </div>

    </div>
    <!-- /bio -->


    <!-- tools -->
    <?php
        $tools_title = get_theme_mod( "front_page_tools_title" );
        $tools_text = get_theme_mod( "front_page_tools_text" );
        $tools_bgcolor = get_theme_mod( "front_page_tools_bgcolor" );
    ?>
    <div id="tools" class="col-xs-12 front_page_section" style="background-color: <?php echo $tools_bgcolor; ?>;">

        <h2 class="section_title">
            <?php echo $tools_title; ?>
        </h2>

        <?php if( !empty( $tools_text ) ): ?>
            <p>
                <?php echo $tools_text; ?>
            </p>
        <?php endif; ?>

        <?php
            if( is_active_sidebar( "front_page_tools_sidebar" ) )
                dynamic_sidebar( "front_page_tools_sidebar" );
        ?>

    </div>
    <!-- /tools -->


    <!-- portfolio -->
    <?php
        // DONE: needs testing with MULTIPLE dummy data
        $portfolio_title = get_theme_mod( "front_page_portfolio_title" );
        $portfolio_text = get_theme_mod( "front_page_portfolio_text" );
        $portfolio_bgcolor = get_theme_mod( "front_page_portfolio_bgcolor" );
        $portfolio_link = get_theme_mod( "front_page_portfolio_link" );
        $portfolio_items = get_theme_mod( "front_page_portfolio_items" );
    ?>
    <div id="portfolio" class="col-xs-12 front_page_section" style="background-color: <?php echo $portfolio_bgcolor; ?>;">

        <h2 class="section_title">
            <?php echo $portfolio_title; ?>
        </h2>

        <?php if( !empty( $portfolio_text ) ): ?>
            <p>
                <?php echo $portfolio_text; ?>
            </p>
        <?php endif; ?>

        <?php
            $query_args = array(
                "post_type" => "portfolio",
                "posts_per_page" => $portfolio_items
            );

            $results = new WP_Query( $query_args );

            while( $results->have_posts() ):
                $results->the_post();
                $permalink = get_permalink();
        ?>
            <div class="portfolio_item col-xs-12">

                <div class="col-xs-12">

                    <h3> <?php the_title(); ?> </h3>

                    <div class="title_underline"></div>

                </div>

                <div class="col-xs-12 col-sm-4 col-md-3">

                    <a class="thumbnail" href="<?php echo $permalink; ?>">
                        <img src="<?php echo getFeaturedImgSrc( $post->ID ); ?>" alt="<?php echo $post->post_title; ?>" />
                    </a>

                </div>

                <div class="col-xs-12 col-sm-8 col-md-9">

                    <div class="col-xs-12">
                        <?php the_excerpt(); ?>
                    </div>

                    <div class="col-xs-12">
                        <?php
                        // TODO: create function to output tech list as links, custom tax
                        // for stack i.e. list of technologies used
                        $terms = getTermsAndLinks( $post->ID,  "tech" );
                        // var_dump( $terms );
                        if( isset( $terms ) ): ?>

                            <div class="tech_list list-group">

                            <?php
                                foreach ( $terms as $term ):
                            ?>

                                <a class="list-group-item" href="<?php echo $term[1]; ?>">
                                    <?php echo $term[0]; ?>
                                </a>

                            <?php
                                endforeach;
                            ?>

                        </div>

                    <?php endif; ?>

                    </div>

                    <div class="project_link col-xs-12">

                        <a class="project_link btn btn-info btn-lg" href="<?php echo $permalink; ?>" >
                            explore
                        </a>

                    </div>

                </div>

            </div>
        <?php
            endwhile;
        ?>

    </div>
    <!-- /portfolio -->


    <!-- contact -->
    <?php
        // TODO: create ajax call and ajax listener, use wp_mail
        $contact_title = get_theme_mod( "front_page_contact_title" );
        $contact_text = get_theme_mod( "front_page_contact_text" );
        $contact_bgcolor = get_theme_mod( "front_page_contact_bgcolor" );
        $contact_link = get_theme_mod( "front_page_contact_link" );
        $nonce = wp_create_nonce("send_email");
    ?>
    <div id="contact" class="col-xs-12 front_page_section" style="background-color: <?php echo $contact_bgcolor; ?>;">

        <?php if( !empty( $contact_title ) ): ?>
            <h2 class="section_title">
                <?php echo $contact_title; ?>
            </h2>
        <?php endif; ?>

        <?php if( !empty( $contact_text ) ): ?>
            <p>
                <?php echo $contact_text; ?>
            </p>
        <?php endif; ?>

        <form id="contact_form" method="POST" action="wp-admin/admin-ajax.php" data-wp-action="send_email">

            <div class="alert alert-info hidden" role="alert"></div>

            <input name="nonce" class="hidden" value="<?php echo $nonce; ?>"/>

            <div class="col-xs-12 col-sm-6">
                <input name="subject" class="subject" type="text" placeholder="subject" required/>
            </div>

            <div class="col-xs-12 col-sm-6">
                <input name="email_address" class="email" type="email" placeholder="your@email.address" required/>
            </div>

            <div class="col-xs-12">
                <textarea name="msg" class="" placeholder="message" required></textarea>
            </div>

            <div class="col-xs-12">
                <button class="btn btn-lg btn-success" type="submit"/>send</button>
            </div>

        </form>

    </div>
    <!-- /contact -->

</main>


<?php //get_sidebar(); ?>

<?php get_footer(); ?>
