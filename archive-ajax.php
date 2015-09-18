<?php

    /*
        Template Name: Archives Getter
    */

    $year = htmlspecialchars(trim($_POST['digwp_y']));
    $month = htmlspecialchars(trim($_POST['digwp_m']));
    $cat = htmlspecialchars(trim($_POST['digwp_c']));

    $querystring = "year=$year&monthnum=$month&cat=$cat&posts_per_page=-1";

    query_posts($querystring);

?>

<?php if (($year == '') && ($month == '') && ($cat == '-1')) { ?>

	<table id="archives-table"><tr><td style='text-align: center; font-size: 15px; padding: 5px;'>Please choose from above.</td></tr></table>

<?php } else { ?>

	<table id="archives-table" class="table table-striped">
	    <?php
	        if (have_posts()) : while (have_posts()) : the_post(); ?>
	            <tr>
	            	<td><img src="<?php echo get_post_meta($post->ID, 'PostThumb', true); ?>" alt="" style="width: 35px;" /></td>
	            	<td><a href='<?php the_permalink(); ?>'><?php the_title(); ?></a></td>
	            	<td><?php comments_popup_link(' ', '1 Comment', '% Comments'); ?></td>
	            	<td><?php the_date('m/j/Y'); ?></td>
	            </tr>
	    <?php
	        endwhile; else:

	        	echo "<tr><td style='text-align: center; font-size: 15px; padding: 5px;'>Nothing found.</td></tr>";

	        endif;
	    ?>
	</table>

<?php } ?>
