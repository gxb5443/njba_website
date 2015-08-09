
<?php if ( post_password_required() ) : ?>
		<p><?php _e( 'This post is password protected. Enter the password to view any comments.', THEMENAME ); ?></p>
<?php
		return;
	endif;
?>

<?php if ( have_comments() ) : ?>
		<?php
            /* Loop through and list the comments. Tell wp_list_comments()
             */
            wp_list_comments( array( 'callback' => 'candidate_comment', 'per_page' => 15) );
        ?>
        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                        <?php previous_comments_link( __( ' Older Comments', THEMENAME ) ); ?>
                        <?php next_comments_link( __( 'Newer Comments ', THEMENAME ) ); ?>
        <?php endif; // check for comment navigation ?>
<?php else : // or, if we don't have comments:

	  ?>
	<p><?php _e( 'No Comments', THEMENAME ); ?></p> 
	 
	<?php if ( ! comments_open() ) : ?>
		<p><?php _e( 'Close Comments', THEMENAME ); ?></p>
	<?php endif; // end ! comments_open() ?>
<?php endif; // end have_comments() ?>