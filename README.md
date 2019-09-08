# social-share
Fastest Social Sharing Plugin for WordPress.

# Usage

add_filter( 'the_content', 'output_shortcode_content' );

function output_shortcode_content( $content ) {


	if ( ! is_singular( array( 'post', '' ) )  ) {

		return $content;
	}

	//shortcode
	$before_shortcode	= do_shortcode( '[social-share style="with-label"]' );
	$after_shortcode 	= do_shortcode( '[social-share style="is-circle"]' );

	//conditional content return
	$before_content = $before_shortcode . $content;
	$after_content 	= $content . $after_shortcode;
	$full_content 	= $before_shortcode . $content . $after_shortcode;

		return $full_content;
}
