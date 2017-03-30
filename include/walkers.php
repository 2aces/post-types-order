<?php

    class Post_Types_Order_Walker extends Walker 
        {

            var $db_fields = array ('parent' => 'post_parent', 'id' => 'ID');


            function start_lvl(&$output, $depth = 0, $args = array()) {
                $indent = str_repeat("\t", $depth);
                $output .= "\n$indent<ul class='children'>\n";
            }


            function end_lvl(&$output, $depth = 0, $args = array()) {
                $indent = str_repeat("\t", $depth);
                $output .= "$indent</ul>\n";
            }


            function start_el(&$output, $page, $depth = 0, $args = array(), $id = 0) {
                if ( $depth )
                    $indent = str_repeat("\t", $depth);
                else
                    $indent = '';

                extract($args, EXTR_SKIP);

                $item_details   =   apply_filters( 'the_title', $page->post_title, $page->ID );
                $item_details   =   apply_filters('cpto/interface_itme_data', $item_details, $page);
                
				$item_terms = get_the_terms( $page->ID, 'serie' );
				if ( $terms && ! is_wp_error( $terms ) ) {
			 
				    $terms_links = array();
				 
				    foreach ( $terms as $term ) {
				        $terms_links[] = $term->name;
				    }
				                         
				    $series = ' | Séries: ' . join( ", ", $terms_links ) . '</div>';
			    }
    
				if( has_post_thumbnail( $page->ID ) ) {
				    $item_thumbnail = get_the_post_thumbnail( $page->ID , 'post_listing_thumbnail' );
				} else {
				    $item_thumbnail = 'No Thumbnail Set';
				}
				$item_details = $item_details . ' | ID: ' . $page->ID . '<span class="reorder-series">' . $series . '</span><span class="reorder-thumbnail">' . $item_thumbnail . '</span>';
                                
                $output .= $indent . '<li id="item_'.$page->ID.'"><span>'. $item_details .'</span>';
                
                
                                
            }


            function end_el(&$output, $page, $depth = 0, $args = array()) {
                $output .= "</li>\n";
            }

        }



?>