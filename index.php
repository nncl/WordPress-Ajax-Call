<?php
/**
 * Created by PhpStorm.
 * User: cauebrunodealmeida
 * Date: 9/17/15
 * Time: 19:53
 */
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Testing it</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
        <style>
            .active {
                font-weight: bold;
            }

            a {
                color: #000;
                cursor: pointer;
            }
        </style>
    </head>

    <body class="text-center">
        <h1>WordPress Ajax Example</h1>
        <p>Click on a category and see how their posts are displayed.</p>

        <?php

        $categories = get_categories(); ?>

        <table class="table table-striped">
            <tr>
                <?php foreach ( $categories as $cat ) { ?>
                    <td id="cat-<?php echo $cat->term_id; ?>">
                        <a class="<?php echo $cat->slug; ?> ajax" onclick="cat_ajax_get('<?php echo $cat->term_id; ?>');"><?php echo $cat->name; ?></a>
                    </td>
                <?php } ?>
            </tr>
        </table>

        <div id="loading-animation" style="display: none;">
            <img src="http://www.thuntech.com/images/loading.gif"/>
        </div>

        <div id="category-post-content"></div>

        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script>
            function cat_ajax_get(catID) {
                $("a.ajax").removeClass("active");
                $("#cat-" + catID + " a").addClass("active"); //adds class current to the category menu item being displayed so you can style it with css
                $("#loading-animation").show();
                var ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); //must echo it ?>';
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {"action": "load-filter", cat: catID },
                    success: function(response) {
                        $("#category-post-content").html(response);
                        $("#loading-animation").hide();
                        return false;
                    }
                });
            }
        </script>
    </body>
</html>
