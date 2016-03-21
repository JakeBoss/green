<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 * @package mpress
 */

/**
 * Prints HTML with meta information for the current post / page / etc
 * @since  version 1.0.0
 * @param  (array) $args : Array of which information to print
 * @param  (bool)  $icon : Whether to include icons or not
 */
if ( !function_exists( 'mpress_entry_meta' ) ) {
    function mpress_entry_meta( $args = array(), $icon = true ) {
        // If no arguments are passed, assume they want everything
        if( empty( $args ) ) {
            $default_args = array(
                'author'      => true,
                'date'        => true,
                'category'    => true,
                'tags'        => true,
                'comments'    => true,
                'edit'        => true,
                'date_format' => null
            );
        }
        // Else if ANY arguments are passed, assume they only want those
        else {
            $default_args = array(
                'author'      => false,
                'date'        => false,
                'category'    => false,
                'tags'        => false,
                'comments'    => false,
                'edit'        => false,
                'date_format' => null
            );
        }
        // Merge defaults with passed args, if any
        $args = ( !empty( $args ) ) ? array_merge( $default_args, $args ) : $default_args;

        // Begin output
        $output = '<ul class="mpress_entry_meta">';
        // Author output
        if( $args['author'] ) {
            $output .= sprintf( '<li class="author vcard">%s<span itemprop="author" itemscope itemtype="https://schema.org/Person"><a itemprop="url" href="%s"><span itemprop="name">%s</span></a></span></li>', get_mpress_icon( 'author', $icon ), esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() ) );
        }

        // Form date output
        if( $args['date'] ) {
            // Structure post date
            $post_date  = sprintf( '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time>', esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date( $args['date_format'] ) ) );
            // If necessary, append the updated datetime
            $post_date .= ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) ? sprintf( '<time class="updated screen-reader-text" datetime="%1$s" itemprop="dateModified">%2$s</time>', esc_attr( get_the_modified_date( 'c' ) ), esc_html( get_the_modified_date( $args['date_format'] ) ) ) : '';
            // Structure output
            $output .= sprintf( '<li class="date">%s<a href="%s" rel="bookmark">%s</a></li>', get_mpress_icon( 'time', $icon ), esc_url_raw( get_permalink() ), $post_date );
        } // end if date

        // Form category output
        if( $args['category'] && has_category() ) {
            $output .= sprintf( '<li class="category">%s<span itemprop="keywords">%s</span></li>', get_mpress_icon( 'category', $icon ), get_the_category_list( '</span>, <span itemprop="keywords">' ) );
        }

        // Form tags output
        if( $args['tags'] && has_tag() ) {
            $output .= sprintf( '<li class="tags">%s</li>', get_the_tag_list( sprintf( '%s<span itemprop="keywords">', get_mpress_icon( 'tag', $icon ) ), '</span>, <span itemprop="keywords">', '</span>' ) );
        }

        // Form comments output
        if( $args['comments'] ) {
            $comments = get_comments_number();
            if( comments_open() && !is_null( $comments ) ) {
                // Create output based on number of comments to output
                switch( $comments ) {
                    case 0 :
                        $comment_output = sprintf( '<span class="screen-reader-text" itemprop="commentCount">%d</span>%s', $comments, __( 'No Comments', 'mpress' ) );
                        break;
                    case 1 :
                        $comment_output = __( 'One Comment', 'mpress' );
                        break;
                    default :
                        $comment_output = sprintf( '<span itemprop="commentCount">%d</span> %s', $comments, __( 'Comments', 'mpress' ) );
                        break;
                } // end switch
                $output .= sprintf( '<li class="comments">%s<a href="%s">%s</a></li>', get_mpress_icon( 'comment', $icon ), esc_url_raw( get_comments_link() ), $comment_output );
            } // end comments_open()
        }
        // Edit Link
        if( $args['edit'] && current_user_can( 'edit_post', get_current_user_id() ) ) {
            $output .= sprintf( '<li class="edit">%s<a href="%s">%s</a></li>', get_mpress_icon( 'edit', $icon ), get_edit_post_link(), __( 'Edit', 'mpress' ) );
        }
        // Close output
        $output .= '</ul>';
        // Echo to screen
        echo $output;
    }
}
/* -------------------------------------------------------------------------- */

/**
 * Returns true if a blog has more than 1 category.
 * @return bool
 */
function mpress_categorized_blog() {
    if ( false === ( $all_the_cool_cats = get_transient( 'mpress_categories' ) ) ) {
        // Create an array of all the categories that are attached to posts.
        $all_the_cool_cats = get_categories( array(
            'fields'     => 'ids',
            'hide_empty' => 1,

            // We only need to know if there is more than one category.
            'number'     => 2,
        ) );

        // Count the number of categories that are attached to the posts.
        $all_the_cool_cats = count( $all_the_cool_cats );

        set_transient( 'mpress_categories', $all_the_cool_cats );
    }

    if ( $all_the_cool_cats > 1 ) {
        // This blog has more than 1 category so mpress_categorized_blog should return true.
        return true;
    } else {
        // This blog has only 1 category so mpress_categorized_blog should return false.
        return false;
    }
}

/**
 * Flush out the transients used in mpress_categorized_blog.
 */
function mpress_category_transient_flusher() {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient( 'mpress_categories' );
}
add_action( 'edit_category', 'mpress_category_transient_flusher' );
add_action( 'save_post',     'mpress_category_transient_flusher' );

/**
 * Output breadcrumb navigation
 * @since version 1.1.0
 */
if( !function_exists( 'output_mpress_breadcrumbs' ) ) {
    function output_mpress_breadcrumbs() {
        // Initailize the $post object
        if( !isset( $post ) ) {
            $post = get_queried_object();
        }
        // Initialize item count
        $item_count = 1;
        // Manage all microdata in this one place
        $microdata = array(
            'li'       => 'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"',
            'link'     => 'itemprop="url"',
            'name'     => 'itemprop="name"',
            'position' => '<meta itemprop="position" content="%d" />'
        );
        // Begin output with nav & ul wrapper
        $output  = '<nav class="breadcrumbs" role="navigation">';
        $output .= '<ul class="breadcrumbs-list" itemscope itemtype="http://schema.org/BreadcrumbList">';
        // Output Homepage item
        $output .= sprintf(
            '<li %1$s class="home"><a %2$s rel="home" href="%3$s">%4$s<span %5$s>%6$s</span></a>%7$s</li>',
            $microdata['li'],
            $microdata['link'],
            esc_url( get_option( 'home' ) ),
            get_mpress_icon( 'home' ),
            $microdata['name'],
            __( 'Home', 'mpress' ),
            sprintf( $microdata['position'], $item_count )
        );
        // Increment the item count
        ++$item_count;
        // Add breadcrumbs for appropriate content type
        switch( mpress_content_type( $post ) ) {
            case 'blog' : // Page that displays blog posts
                $output .= mpress_blog_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'page' : // Single page
                $output .= mpress_page_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'post' : // Single post
                $output .= mpress_post_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'attachment' : // Single attachment page
                $output .= mpress_page_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'custom' : // Single custom post type
                $output .= mpress_custom_type_breadcrumb( $post, $item_count, $microdata );
                break;
            case '404' : // 404 page
                $output .= mpress_404_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'search' : // Search results page
                $output .= mpress_search_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'day' : // Day archive
                $output .= mpress_date_archive_breadcrumb( $post, $item_count, $microdata, 'F jS, Y', __( 'Day:', 'mpress' ) );
                break;
            case 'month' : // Month archive
                $output .= mpress_date_archive_breadcrumb( $post, $item_count, $microdata, 'F, Y', __( 'Month:', 'mpress' ) );
                break;
            case 'year' : // Year archive
                $output .= mpress_date_archive_breadcrumb( $post, $item_count, $microdata, 'Y', __( 'Year:', 'mpress' ) );
                break;
            case 'category' : // Cat archive
                $output .= mpress_category_archive_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'tag' : // Tag archive
                $output .= mpress_tag_archive_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'author' : // Author archive
                $output .= mpress_author_archive_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'type_archive' : // Generic archive for custom post types
                $output .= mpress_type_archive_breadcrumb( $post, $item_count, $microdata );
                break;
            case 'tax_archive' : // Generic archive for custom taxonomies
                $output .= mpress_tax_archive_breadcrumb( $post, $item_count, $microdata );
                break;
            default :
                break;
        } // end switch
        // Close breadcrumbs list
        $output .= '</ul></nav>';
        // Echo output to screen
        echo $output;
    }
    add_action( 'mpress_breadcrumbs', 'output_mpress_breadcrumbs' );
}
/* -------------------------------------------------------------------------- */
function mpress_content_type( $post ) {
    if( is_home( $post ) && !is_front_page( $post ) ) {
        return 'blog';
    } elseif( is_404( $post ) ) {
        return '404';
    } elseif( is_singular( $post ) ) {
        $post_type = get_post_type( $post );
        if( in_array( $post_type, array( 'post', 'page', 'attachment' ) ) ) {
            return $post_type;
        } else {
            return 'custom';
        }
    } elseif( is_category( $post ) ) {
        return 'category';
    } elseif( is_tag( $post ) ) {
        return 'tag';
    } elseif( is_day( $post ) ) {
        return 'day';
    } elseif( is_month( $post ) ) {
        return 'month';
    } elseif( is_year( $post ) ) {
        return 'year';
    } elseif( is_author( $post ) ) {
        return 'author';
    } elseif( is_search( $post ) ) {
        return 'search';
    } elseif( is_tax( $post ) ) {
        return 'tax_archive';
    } elseif( is_archive( $post ) ) {
        return 'type_archive';
    }
    return false;
}

function mpress_blog_breadcrumbs( $post, $item_count, $microdata ) {
    // Initialize output object
    $output  = '';
    $output .= sprintf(
        '<li %1$s><span %2$s>%3$s</span>%4$s</li>',
        $microdata['li'],
        $microdata['name'],
        get_the_title(),
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_ancester_breadcrumb( $post, $item_count, $microdata ) {
    // Initialize output object
    $output = '';
    // Output page ancesters
    $ancesters = get_post_ancestors( $post );
    if( !empty( $ancesters ) ) {
        // Output ancester pages
        foreach( array_reverse( $ancesters ) as $ancester ) {
            $output .= sprintf(
                '<li %s><a %s href="%s" rel="bookmark"><span %s>%s</span></a>%s</li>',
                $microdata['li'],
                $microdata['link'],
                get_the_permalink( $ancester ),
                $microdata['name'],
                get_the_title( $ancester ),
                sprintf( $microdata['position'], $item_count )
            );
            ++$item_count;
        }
    }
    return $output;
}

function mpress_page_breadcrumb( $post, $item_count, $microdata ) {
    // Initialize output object
    $output = '';
    // Output page ancesters
    $output .= mpress_ancester_breadcrumb( $post, $item_count, $microdata );
    // Output THIS pages title
    $output .= sprintf(
        '<li %s><span %s>%s</span>%s</li>',
        $microdata['li'],
        $microdata['name'],
        get_the_title(),
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_post_breadcrumb( $post, $item_count, $microdata ) {
    // Initialize output object
    $output  = '';
    // Count the number of categories, including parent / grandparent categories and append to item_count
    $count = mpress_count_the_category_list( 'multiple' ) + $item_count;
    if( $count > 2 ) {
        // Output Categories
        $output .= sprintf(
            '<li %s>%s</li>',
            $microdata['li'],
            mpress_get_the_category_list( $item_count, sprintf('</li><li %s>', $microdata['li'] ), 'multiple' )
        );
    }
    // Output list item of current post
    $output .= sprintf(
        '<li %1$s><span class="%2$s">%3$s</span>%4$s</li>',
        $microdata['li'],
        $microdata['name'],
        get_the_title(),
        sprintf( $microdata['position'], $count )
    );
    return $output;
}

function mpress_custom_type_breadcrumb( $post, $item_count, $microdata ) {
    // Output slug
    $post_type = get_post_type_object( get_post_type() );
    $output = sprintf(
        '<li %s><a %s href="%s" rel="bookmark"><span %s>%s</span></a>%s</li>',
        $microdata['li'],
        $microdata['link'],
        home_url( sprintf( '%s/', $post_type->rewrite['slug'] ) ),
        $microdata['name'],
        $post_type->rewrite['slug'],
        sprintf( $microdata['position'], $item_count )
    );
    ++$item_count;
    // Output page ancesters
    $output .= mpress_ancester_breadcrumb( $post, $item_count, $microdata );
    // Append any ancestors
    $ancesters = get_post_ancestors( $post );
    // Output this pages title
    $output .= sprintf( '<li %s><span %s>%s</span>%s</li>',
        $microdata['li'],
        $microdata['name'],
        get_the_title( $post ),
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_category_archive_breadcrumb( $post, $item_count, $microdata ) {
    // Initialize output
    $output = '';
    // Get pagination
    $paged = mpress_pagination_breadcrumb( $post, $item_count, $microdata );
    // Get anscesters
    $parents = get_category_parents( $post->term_id, true, '%#%', false, array( $post->term_id ) );
    $par = get_term($post->parent, '' );
    $parent_cats = explode( '%#%', $parents );
    print_r($par);
    // $output .= mpress_ancester_breadcrumb( $post, $item_count, $microdata );
    // output without link if no pagingation is present
    if( empty( $paged ) ) {
        $output .= sprintf(
            '<li %1$s><span %2$s>%3$s</span>%4$s</li>',
            $microdata['li'],
            $microdata['name'],
            single_cat_title( '', false ),
            sprintf( $microdata['position'], $item_count )
        );
    }
    // Otherwise we need to include a link
    else {
        $output .= sprintf(
            '<li %1$s class="home"><a %2$s rel="index" href="%3$s"><span %4$s>%5$s</span></a>%6$s</li>',
            $microdata['li'],
            $microdata['link'],
            esc_url( get_category_link( $post->term_id ) ),
            $microdata['name'],
            single_cat_title( '', false ),
            sprintf( $microdata['position'], $item_count )
        );
    }
    // Append the pagination
    $output .= $paged;
    // Return the output
    return $output;
}
function mpress_pagination_breadcrumb( $post, $item_count, $microdata ) {
    // Initialize output
    $output = '';
    // Get page variable
    $page = intval( get_query_var( 'paged', 0 ) );
    // Append pagination if approapriate
    if( $page > 0 ) {
        $output .= sprintf(
            '<li %1$s><span %2$s>%3$s</span>%4$s</li>',
            $microdata['li'],
            $microdata['name'],
            sprintf( 'Page %d', $page ),
            sprintf( $microdata['position'], ++$item_count )
        );
    }
    return $output;
}
function mpress_tag_archive_breadcrumb( $post, $item_count, $microdata ) {
    $output = sprintf(
        '<li %1$s><span %2$s>%3$s %4$s</span>%5$s</li>',
        $microdata['li'],
        $microdata['name'],
         __( 'Tag:', 'mpress' ),
        single_tag_title( '', false ),
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_tax_archive_breadcrumb( $post, $item_count, $microdata ) {
    global $wp_query;
    $term = $wp_query->get_queried_object();
    $title = $term->name;
    $output = sprintf(
        '<li %1$s><span %2$s>%3$s %4$s</span>%5$s</li>',
        $microdata['li'],
        $microdata['name'],
        sprintf( '%s:', $term->taxonomy ),
        $term->name,
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_type_archive_breadcrumb( $post, $item_count, $microdata ) {
    $archive = get_post_type_object( get_post_type( $post ) );
    $name    = ( !empty( $archive->rewrite['slug'] ) ) ? esc_attr( $archive->rewrite['slug'] ) : $archive->labels->name;
    $output  = sprintf(
        '<li %1$s><span %2$s>%3$s</span>%4$s</li>',
        $microdata['li'],
        $microdata['name'],
        $name,
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_date_archive_breadcrumb( $post, $item_count, $microdata, $format, $pre = null ) {
    $pre = ( $pre === null ) ? __( 'Date:', 'mpress' ) : $pre;
    $output .= sprintf(
        '<li %1$s><span %2$s>%3$s %4$s</span>%5$s</li>',
        $microdata['li'],
        $microdata['name'],
        $pre,
        get_the_time( $format ),
        sprintf( $microdata['position'], 2 )
    );
    return $output;
}

function mpress_404_breadcrumb( $post, $item_count, $microdata ) {
    $output = sprintf(
        '<li %1$s><span %2$s>%3$s</span>%4$s</li>',
        $microdata['li'],
        $microdata['name'],
        __( 'Page Not Found', 'mpress' ),
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}

function mpress_search_breadcrumb( $post, $item_count, $microdata ) {
    $output = sprintf(
        '<li %1$s><span %2$s>%3$s %4$s</span>%5$s</li>',
        $microdata['li'],
        $microdata['name'],
        __( 'Search Results:', 'mpress' ),
        $search,
        sprintf( $microdata['position'], $item_count )
    );
    $search = isset( $_GET['s'] ) ? esc_attr( $_GET['s'] ) : null;
    return $output;
}

function mpress_author_breadcrumb( $post, $item_count, $microdata ) {
    $author = get_userdata( get_query_var( 'author' ) );
    $output = sprintf(
        '<li %1$s><span %2$s>%3$s %4$s</span>%5$s</li>',
        $microdata['li'],
        $microdata['name'],
        __( 'Author: ', 'mpress' ),
        $author->display_name,
        sprintf( $microdata['position'], $item_count )
    );
    return $output;
}


/**
* Retrieve category list in either HTML list or custom format.
* Modified version of Wordpress core get_the_category_list()
* Does not alter the behavior of wordpress core function, just gives an alternative funciton to use when needed
* @since 1.1.0
* @global WP_Rewrite $wp_rewrite
* @param  int    $item_pos  : Optional, the starting position of list items
* @param  string $separator : Optional, default is empty string. Separator for between the categories.
* @param  string $parents   : Optional, How to display the parents.
* @param  int    $post_id   : Optional, Post ID to retrieve categories.
* @return string
* @see https://codex.wordpress.org/Function_Reference/get_the_category_list
*/
if( !function_exists( 'mpress_get_the_category_list' ) ) {
    function mpress_get_the_category_list( $item_pos = 0, $separator = '', $parents = '', $post_id = false ) {
        global $wp_rewrite;
        if ( !is_object_in_taxonomy( get_post_type( $post_id ), 'category' ) ) {
            return apply_filters( 'the_category', '', $separator, $parents );
        }
        $categories = apply_filters( 'the_category_list', get_the_category( $post_id ), $post_id );
        if ( empty( $categories ) ) {
            return apply_filters( 'the_category', __( 'Uncategorized' ), $separator, $parents );
        }
        $rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';
        $thelist = '';
        if ( '' == $separator ) {
            $thelist .= '<ul class="post-categories">';
            foreach ( $categories as $category ) {
                $thelist .= "\n\t<li>";
                switch ( strtolower( $parents ) ) {
                    case 'multiple' :
                        if ( $category->parent ) {
                            $thelist .= mpress_get_category_parents( $item_pos, $category->parent, true, $separator );
                            $item_pos++;
                        }
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name.'</a></li>';
                        break;
                    case 'single' :
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '"  ' . $rel . '>';
                        if ( $category->parent )
                            $thelist .= get_category_parents( $category->parent, false, $separator );
                        $thelist .= $category->name.'</a></li>';
                        break;
                    default :
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name.'</a></li>';
                        break;
                }
            }
            $thelist .= '</ul>';
        } else {
            $i = 0;
            foreach ( $categories as $category ) {
                if ( 0 < $i ) {
                    $thelist .= $separator;
                }
                switch ( strtolower( $parents ) ) {
                    case 'multiple' :
                        if ( $category->parent ) {
                            $thelist .= mpress_get_category_parents( $item_pos, $category->parent, true, $separator );
                            ++$item_pos;
                        }
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '><span itemprop="name">' . $category->name. '</span></a><meta itemprop="position" content="' . $item_pos . '">';
                        break;
                    case 'single' :
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>';
                        if ( $category->parent )
                                $thelist .= mpress_get_category_parents( $item_pos, $category->parent, false, $separator );
                        $thelist .= "$category->name</a>";
                        break;
                    default :
                        $thelist .= '<a itemprop="url" href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name.'</a>';
                        break;
                }
                $i++;
                $item_pos++;
            }
        }
        return apply_filters( 'the_category', $thelist, $separator, $parents );
    }
}
/* -------------------------------------------------------------------------- */

/**
* Retrieve category parents with separator.
* Modified version of Wordpress core get_category_parents() required for breadcrumbs
* Does not alter the behavior of wordpress core function, just gives an alternative funciton to use when needed
* @since  1.1.0
* @param  int               $item_pos           : Required, the starting position of list items
* @param  (int)             $id Category ID.    : Required, the category id to retrieve
* @param  (bool)            $link Optional,     : default is false. Whether to format with link.
* @param  (string)          $separator Optional : default is '/'. How to separate categories.
* @param  (bool)            $nicename Optional, : default is false. Whether to use nice name for display.
* @param  (array)           $visited Optional.  : Already linked to categories to prevent duplicates.
* @return (string|WP_Error) A list of category parents on success, WP_Error on failure.
* @see https://codex.wordpress.org/Function_Reference/get_category_parents
*/
if( !function_exists( 'mpress_get_category_parents' ) ) {
    function mpress_get_category_parents( $item_pos = 0, $id, $link = false, $separator = '/', $nicename = false, $visited = array() ) {
        $chain = '';
        $parent = get_term( $id, 'category' );
        if ( is_wp_error( $parent ) ) {
            return $parent;
        }
        if ( $nicename ) {
            $name = $parent->slug;
        }
        else {
            $name = $parent->name;
        }
        if ( $parent->parent && ( $parent->parent != $parent->term_id ) && !in_array( $parent->parent, $visited ) ) {
            $visited[] = $parent->parent;
            $chain .= get_category_parents( $parent->parent, $link, $separator, $nicename, $visited );
        }
        if ( $link ) {
            $chain .= '<a itemprop="url" href="' . esc_url( get_category_link( $parent->term_id ) ) . '"><span itemprop="name">'.$name.'</span></a><meta itemprop="position" content="' . $item_pos . '">' . $separator;
        }
        else {
            $chain .= $name . $separator;
        }
        return $chain;
    }
}
/* -------------------------------------------------------------------------- */

/**
* Count the number of categories for a single post
* @since  1.1.0
* @param  string $parents   : Optional, How to display the parents.
* @param  int    $post_id   : Optional, Post ID to retrieve categories.
*/
if( !function_exists( 'mpress_count_the_category_list' ) ) {
    function mpress_count_the_category_list( $parents='', $post_id = false ) {
        if ( !is_object_in_taxonomy( get_post_type( $post_id ), 'category' ) ) {
            return 0;
        }
        $categories = apply_filters( 'the_category_list', get_the_category( $post_id ), $post_id );
        // If categories are empty, return 0
        if ( empty( $categories ) ) {
            return 0;
        }
        // Count number of categories
        $count = count( $categories );
        // If multiple is selected for parents, add parents to count
        if( strtolower( $parents ) == 'multiple' ) {
            foreach ( $categories as $category ) {
                $count += ( $category->parent ) ? 1 : 0;
            }
        }
        return $count;
    }
}
/* -------------------------------------------------------------------------- */

/**
* Get the menu target for mobile menu link
* @since  1.1.0
*/
if( !function_exists( 'get_mpress_menu_target' ) ) {
    function get_mpress_menu_target() {
        return ( get_theme_mod( 'mpress_mobile_menu', 'menu-simple' ) == 'menu-off-canvas' ) ? '.off-canvas-menu #page-wrapper' : '#site-navigation';
    }
}

function mpress_social_links() {
    // Build network list
    $output = '<ul class="social-links">';

    foreach( mpress_social_network_settings() as $network => $setting ) {
        // Get setting from database
        $social_uri = get_option( $setting['slug'], null );
        // Append LI if network is set
        if( $social_uri ) {
            $output .= sprintf( '<li class="%1$s"><a class="social-link" href="%2$s" target="_blank">%3$s<span class="screen-reader-text">%1$s</span></a></li>', $network, esc_url_raw( $social_uri ), get_mpress_icon( $network ) );
        }
    }
    $output .= '</ul>';

    echo $output;
}

function mpress_logo() {
    // Initialize variables
    $logo        = '';
    $title_class = 'site-title';
    $site_logo   = get_theme_mod( 'mpress_site_logo' );
    $mobile_logo = get_theme_mod( 'mpress_mobile_logo' );
    // If either logo is present
    if( $site_logo || $mobile_logo ) {
        if( $site_logo && !empty( $site_logo ) ) {
            $logo        .= sprintf( '<img class="site-logo" src="%1$s" alt="%2$s" title="%3$s" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">', esc_url_raw( $site_logo ), get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
            $title_class .= ' has-logo';
        }
        if( $mobile_logo && !empty( $mobile_logo ) ) {
            $logo        .= sprintf( '<img class="mobile-logo" src="%1$s" alt="%2$s" title="%3$s" itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">', esc_url_raw( $mobile_logo ), get_bloginfo( 'name' ), get_bloginfo( 'description' ) );
            $title_class .= ' has-mobile-logo';
        }
    // Else we can just use the site name
    } else {
        $logo .= sprintf( '<span class="anchor-text">%s</span>', get_bloginfo( 'name' ) );
    }
    $title_type  = ( is_front_page() || is_home() ) ? 'h1' : 'h2';
    // Finally, echo output
    echo sprintf( '<%1$s class="%2$s"><a href="%3$s" rel="home" itemprop="url">%4$s</a></%1$s>', $title_type, $title_class,  esc_url( home_url( '/' ) ), $logo);
    echo sprintf( '<meta itemprop="name" content="%s">', get_bloginfo( 'name' ) );
}