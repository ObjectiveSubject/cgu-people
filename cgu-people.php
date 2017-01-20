<?php
/**
 * @package CGU_People
 * @version 1.0.0
 */
/*
Plugin Name: CGU People
Plugin URI: http://www.github.com/objectivesubject/cgu-people/
Description: Adds support for People to CGU Core themes.
Author: Objective Subject
Version: 1.0.0
Author URI: http://www.objectivesubject.com
*/

if ( ! class_exists( 'CGU_People' ) ) {

    class CGU_People {

        const VERSION = '1.0.0';

        /**
		 * Static Singleton Holder
		 * @var self
		 */
		protected static $instance;



		/**
		 * Get (and instantiate, if necessary) the instance of the class
		 *
		 * @return self
		 */
		public static function instance() {
			if ( ! self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}



        /**
		 * Initializes plugin variables and sets up WordPress hooks/actions.
		 */
        protected function __construct() {

            $this->plugin_path = dirname( __FILE__ ) . '/';

            add_action( 'init',            array( 'CGU_People', 'register_post_types' ) );
            add_action( 'init',            array( 'CGU_People', 'register_taxonomies' ) );
            add_action( 'cmb2_init',       array( 'CGU_People', 'register_custom_fields' ) );

            $this->register_shortcodes();
            $this->register_templates();

        }



        /**
    	 * Register post types
    	 */
        public static function register_post_types() {

            /* The "Extended Post Types" library is part of CGU Core
             */
            if ( function_exists('register_extended_post_type') ) {

                register_extended_post_type( 'people', array(

            		'menu_icon' => 'dashicons-groups',
            		'supports' => array('title', 'editor', 'thumbnail', 'page-attributes', 'excerpt'),
            		'has_archive' => false,
            		# Add some custom columns to the admin screen:
            		'admin_cols' => array(
            			'role' => array(
            				'taxonomy' => 'role'
            			)
            		)

            	), array(

            		# Override the base names used for labels:
            		'singular' => 'Person',
            		'plural'   => 'People',
            		'slug'     => 'people'

            	) );

            }

        } // register_post_types



        /**
    	 * Register taxonomies
    	 */
        public static function register_taxonomies() {

            /* The "Extended Taxonomies" library is part of CGU Core
             */
            if ( function_exists('register_extended_taxonomy') ) {

                register_extended_taxonomy( 'role', 'people' );

            }

        } // register_taxonomies



        /**
    	 * Register custom fields
    	 */
        public static function register_custom_fields() {

            /* The "CMB2" library is part of CGU Core
             */
            if ( function_exists( 'new_cmb2_box' ) ) {

                /**
                 * People social media metabox
                 */
                 $prefix = 'people_';
                 $channels = array(
                     'facebook' => 'Facebook',
                     'twitter' => 'Twitter',
                     'linkedin' => 'LinkedIn',
                     'instagram' => 'Instagram',
                     'youtube' => 'YouTube',
                     'google' => 'Google+'
                 );

                 $cmb = new_cmb2_box( array(
                     'id'           => $prefix . 'social_media_metabox',
                     'title'        => __( 'Social Media URLs', 'cmb2' ),
                     'object_types' => array( 'people' ),
                     'context'	   => 'side',
                     'priority'	   => 'low'
                 ) );

                 foreach ( $channels as $slug => $name ) {
                     $cmb->add_field( array(
                         'name' => __( $name, 'cmb2' ),
                         'id'   => $prefix . $slug,
                         'type' => 'text'
                     ) );
                 }

                /**
                 * People options metabox
                 */
                 $cmb = new_cmb2_box( array(
                     'id'           => $prefix . 'metabox',
                     'title'        => __( 'Personal Info', 'cmb2' ),
                     'object_types' => array( 'people' )
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Title', 'cmb2' ),
                     'desc' => __( 'e.g. "Director of Admissions"', 'cmb2' ),
                     'id'   => $prefix . 'title',
                     'type' => 'textarea_small'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Email', 'cmb2' ),
                     'desc' => __( 'e.g. "john@cgu.edu"', 'cmb2' ),
                     'id'   => $prefix . 'email',
                     'type' => 'text'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Website Display', 'cmb2' ),
                     'id'   => $prefix . 'website_display',
                     'type' => 'text',
                     'attributes' => array(
                         'placeholder' => 'John Smith\'s Website'
                     )
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Website URL', 'cmb2' ),
                     'id'   => $prefix . 'website',
                     'type' => 'text',
                     'attributes' => array(
                         'placeholder' => 'http://www.johnsmith.com'
                     )
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'CV (PDF)', 'cmb2' ),
                     'id'   => $prefix . 'cv',
                     'type' => 'file'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Phone', 'cmb2' ),
                     'desc' => __( 'e.g. "(555) 555-5555"', 'cmb2' ),
                     'id'   => $prefix . 'phone',
                     'type' => 'text'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Degrees', 'cmb2' ),
                     'desc' => __( 'e.g. "PhD, History, UCLA"', 'cmb2' ),
                     'id'   => $prefix . 'degrees',
                     'type' => 'textarea_small'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Research Interests', 'cmb2' ),
                     'id'   => $prefix . 'expertise',
                     'type' => 'textarea_small'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Custom Program/Area of Study content', 'cmb2' ),
                     'desc' => __( 'Override the "Research Interests" and "Programs" list in this person\'s profile.', 'cmb2' ),
                     'id'   => $prefix . 'custom_program_aos',
                     'type' => 'textarea_small'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Works', 'cmb2' ),
                     'id'   => $prefix . 'works',
                     'type' => 'wysiwyg'
                 ) );

                 $cmb->add_field( array(
                     'name' => __( 'Classes', 'cmb2' ),
                     'id'   => $prefix . 'classes',
                     'type' => 'wysiwyg'
                 ) );


            }

        } // register_custom_fields



        /**
    	 * Register shortcodes
    	 */
        public static function register_shortcodes() {

            add_shortcode( 'profiles', 'profiles_func' );

            /**
             * Create a profile block
             *
             * @param $attributes array List of attributes from the given shortcode
             *
             * @return mixed HTML output for the shortcode
             */
            function profiles_func( $attributes ) {

            	$data = shortcode_atts( array(
            		'ids' => 0,
            		'includes' => '',
            		'span' => '4',
            		'link_to_profile' => 'true',
            	), $attributes );

            	$post_ids = $data['ids'];
            	if ( ! $post_ids ) {
            		return;
            	} else {
            		$post_ids = array_map( 'trim', explode( ',', $data['ids'] ) );
            	}

            	$profiles = new \WP_Query( array(
            		'post_type' => array( 'people', 'student' ),
            		'post__in' => $post_ids,
            		'orderby' => 'post__in',
            		'order'	=> 'ASC',
            		'posts_per_page' => 100,
            		'ignore_sticky_posts' => true,
            		'no_found_rows' => true
            	) );

            	if ( ! $profiles->have_posts() ) {
            		return;
            	}

            	$includes = array_map( 'trim', explode( ',', $data['includes'] ) );
            	$includes = array_map( 'strtolower', $includes );
            	$is_singular_profile = ( 1 == $profiles->post_count ) ? true : false;

            	ob_start(); ?>

            		<?php if ( ! $is_singular_profile ) {
            			echo '<div class="u-clear">';
            		} ?>

            			<?php while ( $profiles->have_posts() ) : $profiles->the_post(); ?>

            				<div class="profile u-push u-span-<?php echo $data['span']; ?>" style="<?php echo ( $is_singular_profile ) ? 'margin-right: 1.5em; margin-bottom:3em' : ''; ?>">

            					<?php
            					$post_id 	= get_the_ID();
            					$name      	= get_the_title();
            					$margin 	= '';

            					// Profile image

            					if ( in_array( 'image', $includes ) ) {
            						$thumbnail = get_the_post_thumbnail( $post_id, 'profile', array( 'class' => 'u-display-block', 'alt' => $name . ' profile image' ) );
            						if ( $thumbnail ) {
            							echo $thumbnail;
            						} else {
            							echo '<img src="' . esc_url( \CGU\Helpers\asset( 'images/placeholder_people_1x1_gray.svg' ) ) . '" class="u-display-block" alt="placeholder" width="600" height="400" />';
            						}
            						$margin = 'u-nudge';
            					} else {
            						echo '<hr class="u-hug">';
            					} ?>

            					<?php // Name ?>
            					<h4 class="u-nudge u-weight-bold"><?php echo $name; ?></h4>

            					<?php
            						// Title

            						$title = get_post_meta( $post_id, 'people_title', true );
            						if ( ! empty( $title ) ) {
            							echo '<p class="u-hug">' . nl2br( esc_html( $title ) ) . '</p>';
            						} ?>

            					<?php // Email

            					if ( in_array( 'email', $includes ) ) :
            						$email = get_post_meta( $post_id, 'people_email', true );
            						if ( ! empty( $email ) ) : ?>
            							<h5 class="u-nudge u-color-muted">Email</h5>
            							<a href="mailto:<?php echo sanitize_email( $email ); ?>"><?php echo sanitize_email( $email ); ?></a>
            						<?php endif;
            					endif; ?>

            					<?php // Phone

            					if ( in_array( 'phone', $includes ) ) :
            						$phone = get_post_meta( $post_id, 'people_phone', true );
            						if ( ! empty( $phone ) ) : ?>
            							<h5 class="u-nudge u-color-muted">Phone</h5>
            							<span><?php echo $phone; ?></span>
            						<?php endif;
            					endif; ?>

            					<?php // Website

                                if ( in_array( 'website', $includes ) ) :
            						$website = get_post_meta( $post_id, 'people_website', true );
            						if ( ! empty( $website ) ) :
            							$website_display = get_post_meta( $post_id, 'people_website_display', true ); ?>
            							<h5 class="u-nudge u-color-muted">Website</h5>
            							<a href="<?php echo esc_url( $website ); ?>">
            								<?php echo ( $website_display ) ? esc_html( $website_display ) : esc_url( $website_url ); ?>
            							</a>
            						<?php endif;
            					endif; ?>

            					<?php // CV

            					if ( in_array( 'cv', $includes ) ) :
            						$cv = get_post_meta( $post_id, 'people_cv', true );
            						if ( ! empty( $cv ) ) : ?>
            							<h5 class="u-nudge u-color-muted">CV</h5>
            							<a href="<?php echo esc_url($cv); ?>">Download (PDF)</a>
            						<?php endif;
            					endif; ?>

            					<?php // Degrees

            					if ( in_array( 'degrees', $includes ) ) :
            						$degrees = get_post_meta( $post_id, 'people_degrees', true );
            						if ( ! empty( $degrees ) ) : ?>
            							<h5 class="u-nudge u-color-muted">Degrees</h5>
            							<span><?php echo nl2br( $degrees ); ?></span>
            						<?php endif;
            					endif; ?>

            					<?php

            					// Programs & expertise

            					if ( in_array( 'expertise', $includes ) ) :

            						$custom_program_aos_content = get_post_meta( $post_id, 'people_custom_program_aos', true );

            						// IF Custom Content //////////////////////////////////////////////////
            						if ( $custom_program_aos_content ) : ?>

            							<h5 class="u-nudge u-color-muted">Programs</h5>
            							<p class="u-hug"><?php echo nl2br( $custom_program_aos_content ); ?></p>

            						<?php else : // Otherwise ////////////////////////////////////////////////// ?>

            							<?php // IF Expertise ----------------------
            							if ( in_array( 'expertise', $includes ) ) {

            								$expertise = get_post_meta( $post_id, 'people_expertise', true );

            								if ( ! empty( $expertise ) ) { ?>

            									<h5 class="u-nudge u-color-muted">Research Interests</h5>
            									<p class="u-hug"><?php echo nl2br( $expertise ); ?></p>

            								<?php } ?>

            							<?php } ?>

            						<?php endif; ?>

            					<?php endif; // END Programs & Expertise /////////////////////////////////// ?>


            					<?php // Profile Link

            					if ( 'false' !== $data['link_to_profile'] ) : ?>
            						<div class="u-nudge">
            							<a href="<?php the_permalink(); ?>" class="u-font-mercury">View profile <span aria-hidden="true" class="icon-arrow-right u-font-size-sm"></span></a>
            						</div>
            					<?php endif; ?>
            				</div>

            			<?php endwhile; wp_reset_query(); ?>

            		<?php if ( ! $is_singular_profile ) {
            			echo '</div>';
            		} ?>

            	<?php
            	$html = ob_get_contents();
            	ob_get_clean();

            	return $html;
            }

        } // register_shortcodes



        /**
    	 * Register templates
    	 */
        public static function register_templates() {

            add_filter( 'single_template', 'get_people_template' );

            function get_people_template($single_template) {
                 global $post;

                 if ( $post->post_type == 'people' ) {
                      $single_template = dirname( __FILE__ ) . '/templates/single-people.php';
                 }
                 return $single_template;
            }

        }


    }
}

CGU_People::instance();
