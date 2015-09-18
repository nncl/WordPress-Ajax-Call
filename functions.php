<?php
/**
 * Created by PhpStorm.
 * User: cauebrunodealmeida
 * Date: 9/17/15
 * Time: 20:06
 */

function prefix_load_cat_posts () {
    $cat_id = $_POST[ 'cat' ];
    $args = array (
        'cat' => $cat_id,
        'posts_per_page' => 10,
        'order' => 'DESC'

    );

    global $post;
    $posts = get_posts( $args );

    ob_start ();

    foreach ( $posts as $post ) {
        setup_postdata( $post ); ?>

        <div id="post-<?php echo $post->ID; ?>">
            <h1 class="posttitle">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h1>

            <div id="post-content">
                <?php the_excerpt(); ?>
            </div>

        </div>

    <?php } wp_reset_postdata();

    $response = ob_get_contents();
    ob_end_clean();

    echo $response;
    die(1);
}

add_action( 'wp_ajax_nopriv_load-filter', 'prefix_load_cat_posts' );
add_action( 'wp_ajax_load-filter', 'prefix_load_cat_posts' );
