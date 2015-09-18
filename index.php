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
        <article role="article">
          <h1>WordPress Ajax Example</h1>
          <p>Click on a category and see how their posts are displayed.</p>
          <?php

          $categories = get_categories(); ?>

          <table class="table table-striped">
              <tr>
                  <?php foreach ( $categories as $cat ) { ?>
                      <td id="cat-<?php echo $cat->term_id; ?>">
                          <a class="<?php echo $cat->slug; ?> ajax" data-cat="<?php echo $cat->term_id ?>">
                              <?php echo $cat->name; ?>
                          </a>
                      </td>
                  <?php } ?>
              </tr>
          </table>

          <div id="loading-animation" style="display: none;">
              <img src="http://www.thuntech.com/images/loading.gif"/>
          </div>

          <div id="category-post-content"></div>
        </article>

        <article role="article">
          <h1>WordPress Ajax <strong>Archive</strong> Example</h1>
          <p>Different than other one, here we can select a month and category and show the posts below it.</p>

          <table id="archive-browser" class="table table-striped">
            <tr>
              <td>
                <h4>Month</h4>
                <select id="month-choice">
                  <option val="no-choice"> &mdash; </option>
                  <?php wp_get_archives(array(

                    'type'    => 'monthly',
                    'format'  => 'option'

                  )); ?>
                </select>
              </td>
              <td>
                <h4>Category</h4>
                <?php

                  wp_dropdown_categories('show_option_none= -- ');

                ?>
              </td>
            </tr>
          </table>

          <div id="archive-pot"></div>
        </article>

        <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
          <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option>
          <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
        </select>

        <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
        <script>
            function cat_ajax_get() {
                $('a.ajax').on('click' , function() {
                    var catID = $(this).attr('data-cat');

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
                });
            }

            function ajaxSelect() {
              $("#archive-wrapper").height($("#archive-pot").height());

              $("#archive-browser select").change(function() {

                $("#archive-pot")
                  .empty()
                  .html("<div style='text-align: center; padding: 30px;'><img src='http://www.thuntech.com/images/loading.gif' /></div>");

                var dateArray = $("#month-choice").val().split("/");
                var y = dateArray[3];
                var m = dateArray[4];
                var c = $("#cat").val();

                // var archive_url = '<?php echo get_template_directory_uri() ?>/archive-ajax.php';

                $.ajax({

                  url: "/wordpress/?page_id=23/",
                  dataType: "html",
                  type: "POST",
                  data: ({
                    "digwp_y": y,
                    "digwp_m" : m,
                    "digwp_c" : c
                  }),
                  success: function(data) {
                    $("#archive-pot").html(data);

                    $("#archive-wrapper").animate({
                      height: $("#archives-table tr").length * 50
                    });

                  }

                });

              });
            }

            cat_ajax_get();
            ajaxSelect();
        </script>
    </body>
</html>
