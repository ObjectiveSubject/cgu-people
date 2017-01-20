<?php
$prefix     	= 'people_';
$email      	= get_post_meta( $post->ID, $prefix . 'email', true );
$phone      	= get_post_meta( $post->ID, $prefix . 'phone', true );
$website_display= get_post_meta( $post->ID, $prefix . 'website_display', true );
$website_url    = get_post_meta( $post->ID, $prefix . 'website', true );
$cv      		= get_post_meta( $post->ID, $prefix . 'cv', true );
$degrees      	= get_post_meta( $post->ID, $prefix . 'degrees', true );
$expertise		= get_post_meta( $post->ID, $prefix . 'expertise', true );
$social_media	= array(
	'facebook' 	=> get_post_meta( $post->ID, $prefix . 'facebook', true ),
	'twitter' 	=> get_post_meta( $post->ID, $prefix . 'twitter', true ),
	'linkedin' 	=> get_post_meta( $post->ID, $prefix . 'linkedin', true ),
	'instagram' => get_post_meta( $post->ID, $prefix . 'instagram', true ),
	'youtube' 	=> get_post_meta( $post->ID, $prefix . 'youtube', true ),
	'google' 	=> get_post_meta( $post->ID, $prefix . 'google', true )
);
foreach ( $social_media as $key => $value ) {
	if ( ! $value ) {
		unset( $social_media[$key] );
	}
}
?>

<?php if ( has_post_thumbnail() ) {
    the_post_thumbnail( 'profile', array( 'class' => 'u-display-block u-push' )  );
} else {
    echo '<img src="'. esc_url( \CGU\Helpers\asset( 'images/placeholder_people_1x1_gray.svg' ) ) .'" class="u-display-block u-push" alt="placeholder" width="600" height="400" />';
} ?>
<ul class="u-nudge">
    <?php if ( $email ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'Email', 'cgu' ); ?></strong><br/><a href="mailto:<?php echo sanitize_email($email); ?>"><?php echo sanitize_email( $email ); ?></a></li>
    <?php endif; ?>
    <?php if ( $phone ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'Phone', 'cgu' ); ?></strong><br/><?php echo $phone; ?></li>
    <?php endif; ?>
    <?php if ( $website_url ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'Website', 'cgu' ); ?></strong><br/><a href="<?php echo esc_url($website_url); ?>" target="_blank"><?php echo ( $website_display ) ? esc_html( $website_display ) : esc_url( $website_url ); ?></a></li>
    <?php endif; ?>
    <?php if ( $cv ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'CV', 'cgu' ); ?></strong><br/><a href="<?php echo esc_url($cv); ?>"><?php _e( 'Download (PDF)', 'cgu' ); ?></a></li>
    <?php endif; ?>
    <?php if ( $degrees ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'Degrees', 'cgu' ); ?></strong><br/><?php echo nl2br( $degrees ); ?></li>
    <?php endif; ?>
    <?php if ( $expertise ) : ?>
        <li class="u-nudge"><strong class="h5 u-color-muted"><?php _e( 'Research Interests', 'cgu' ); ?></strong><br><div><?php echo nl2br( $expertise ); ?></div></li>
    <?php endif; ?>
    <?php if ( count( $social_media ) ) { ?>
        <li class="u-nudge">
            <div class="h5 u-hug u-color-muted"><?php _e( 'Connect', 'cgu' ); ?></div>
            <ul class="social-media">
            <?php foreach( $social_media as $key => $value ) {
                echo '<li><a href="' . esc_url( $value ) . '" class="' . $key . '" target="_blank"><span class="icon icon-' . $key . '"></span><span class="u-display-none">' . $key . '</span></a></li>';
            } ?>
            </ul>
        </li>
    <?php } ?>
</ul>
