# social-share
Fastest Social Sharing Plugin for WordPress.

# Usage

[social-share]

[social-share title="Default "]

[social-share style="is-circle" title="Circle "]

[social-share style="with-label" title="Label "]

[social-share style="with-radius is-button" title="Button "]

[social-share style="with-border" title="Border Square "]

[social-share style="with-border is-circle" title="Border Circle "]

[social-share position="in-left" linkedin="hide" sms="hide" telegram="hide" style="" title="Left "]

[social-share position="in-right" linkedin="hide" sms="hide" telegram="hide" style="" title="Right "]

Conditional Hide or Show Social Services.
[social-share position="" linkedin="hide" sms="hide" telegram="hide" style=""]

# in functions.php

```php
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
```
