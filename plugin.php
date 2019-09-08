<?php
/**
 * Plugin Name: Social Share
 * Plugin URI:  https://github.com/rockingaryan/social-share
 * Description: A lightweight & fastest social sharing plugin.
 * Author:      Aryan Raj
 * Author URI:  https://www.aryanraj.com/
 * Version:     1.0.0
 * License:     GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Social Share
 */
 
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Enquque Social Share Buttons Styles.
add_action( 'wp_enqueue_scripts', 'social_share_styles' );
function social_share_styles() {
	wp_enqueue_style( 'social-share', plugin_dir_url( __FILE__ ) .  'style.css', array(), '1.0.0', 'all'  );
}

// Create Social Share Buttons Shortcode.
add_shortcode( 'social-share', 'custom_social_share_buttons_shortcode' );

function custom_social_share_buttons_shortcode( $atts, $content = null ) {

	// Attributes
	$ss_atts = shortcode_atts(
		array(
			'position'	=> '',
			'title'		=> '',
			'style'		=> 'default',
			'width'		=> '',
	
			'facebook'	=> 'show',
			'twitter'	=> 'show',
			'pinterest'	=> 'show',
			'linkedin'	=> 'show',
			'whatsapp'	=> 'show',
			'sms'		=> 'hide',
			'telegram'	=> 'hide',

		),
		$atts
		
	);

    global $post;

    // Get current page URL 
	$socialURL = urlencode(get_permalink());
 
	// Get current page title
	$socialTitle = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
		
	// Get Post Thumbnail for pinterest
	$socialThumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );


	// Add Social Media SVG Icons
  	$facebookICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18.8125" height="32" viewBox="0 0 602 1024"><path d="M548 6.857v150.857h-89.714q-49.143 0-66.286 20.571t-17.143 61.714v108h167.429l-22.286 169.143h-145.143v433.714h-174.857v-433.714h-145.714v-169.143h145.714v-124.571q0-106.286 59.429-164.857t158.286-58.571q84 0 130.286 6.857z"></path></svg>';
  	$twitterICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="29.71875" height="32" viewBox="0 0 951 1024"><path d="M925.714 233.143q-38.286 56-92.571 95.429 0.571 8 0.571 24 0 74.286-21.714 148.286t-66 142-105.429 120.286-147.429 83.429-184.571 31.143q-154.857 0-283.429-82.857 20 2.286 44.571 2.286 128.571 0 229.143-78.857-60-1.143-107.429-36.857t-65.143-91.143q18.857 2.857 34.857 2.857 24.571 0 48.571-6.286-64-13.143-106-63.714t-42-117.429v-2.286q38.857 21.714 83.429 23.429-37.714-25.143-60-65.714t-22.286-88q0-50.286 25.143-93.143 69.143 85.143 168.286 136.286t212.286 56.857q-4.571-21.714-4.571-42.286 0-76.571 54-130.571t130.571-54q80 0 134.857 58.286 62.286-12 117.143-44.571-21.143 65.714-81.143 101.714 53.143-5.714 106.286-28.571z"></path></svg>';
  	$pinterestICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="22.84375" height="32" viewBox="0 0 731 1024"><path d="M0 341.143q0-61.714 21.429-116.286t59.143-95.143 86.857-70.286 105.714-44.571 115.429-14.857q90.286 0 168 38t126.286 110.571 48.571 164q0 54.857-10.857 107.429t-34.286 101.143-57.143 85.429-82.857 58.857-108 22q-38.857 0-77.143-18.286t-54.857-50.286q-5.714 22.286-16 64.286t-13.429 54.286-11.714 40.571-14.857 40.571-18.286 35.714-26.286 44.286-35.429 49.429l-8 2.857-5.143-5.714q-8.571-89.714-8.571-107.429 0-52.571 12.286-118t38-164.286 29.714-116q-18.286-37.143-18.286-96.571 0-47.429 29.714-89.143t75.429-41.714q34.857 0 54.286 23.143t19.429 58.571q0 37.714-25.143 109.143t-25.143 106.857q0 36 25.714 59.714t62.286 23.714q31.429 0 58.286-14.286t44.857-38.857 32-54.286 21.714-63.143 11.429-63.429 3.714-56.857q0-98.857-62.571-154t-163.143-55.143q-114.286 0-190.857 74t-76.571 187.714q0 25.143 7.143 48.571t15.429 37.143 15.429 26 7.143 17.429q0 16-8.571 41.714t-21.143 25.714q-1.143 0-9.714-1.714-29.143-8.571-51.714-32t-34.857-54-18.571-61.714-6.286-60.857z"></path></svg>';
	$linkedinICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="27.4375" height="32" viewBox="0 0 878 1024"><path d="M199.429 357.143v566.286h-188.571v-566.286h188.571zM211.429 182.286q0.571 41.714-28.857 69.714t-77.429 28h-1.143q-46.857 0-75.429-28t-28.571-69.714q0-42.286 29.429-70t76.857-27.714 76 27.714 29.143 70zM877.714 598.857v324.571h-188v-302.857q0-60-23.143-94t-72.286-34q-36 0-60.286 19.714t-36.286 48.857q-6.286 17.143-6.286 46.286v316h-188q1.143-228 1.143-369.714t-0.571-169.143l-0.571-27.429h188v82.286h-1.143q11.429-18.286 23.429-32t32.286-29.714 49.714-24.857 65.429-8.857q97.714 0 157.143 64.857t59.429 190z"></path></svg>';
	$whatsappICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="25" height="32" viewBox="0 0 877.7142857142857 1024"><path d="M562.857 556.571c9.714 0 102.857 48.571 106.857 55.429 1.143 2.857 1.143 6.286 1.143 8.571 0 14.286-4.571 30.286-9.714 43.429-13.143 32-66.286 52.571-98.857 52.571-27.429 0-84-24-108.571-35.429-81.714-37.143-132.571-100.571-181.714-173.143-21.714-32-41.143-71.429-40.571-110.857v-4.571c1.143-37.714 14.857-64.571 42.286-90.286 8.571-8 17.714-12.571 29.714-12.571 6.857 0 13.714 1.714 21.143 1.714 15.429 0 18.286 4.571 24 19.429 4 9.714 33.143 87.429 33.143 93.143 0 21.714-39.429 46.286-39.429 59.429 0 2.857 1.143 5.714 2.857 8.571 12.571 26.857 36.571 57.714 58.286 78.286 26.286 25.143 54.286 41.714 86.286 57.714 4 2.286 8 4 12.571 4 17.143 0 45.714-55.429 60.571-55.429zM446.857 859.429c197.714 0 358.857-161.143 358.857-358.857s-161.143-358.857-358.857-358.857-358.857 161.143-358.857 358.857c0 75.429 24 149.143 68.571 210.286l-45.143 133.143 138.286-44c58.286 38.286 127.429 59.429 197.143 59.429zM446.857 69.714c237.714 0 430.857 193.143 430.857 430.857s-193.143 430.857-430.857 430.857c-72.571 0-144.571-18.286-208.571-53.714l-238.286 76.571 77.714-231.429c-40.571-66.857-61.714-144-61.714-222.286 0-237.714 193.143-430.857 430.857-430.857z"></path></svg>';
	$smsICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024"><path d="M804.571 438.857c0 161.714-180 292.571-402.286 292.571-34.857 0-68.571-3.429-100.571-9.143-47.429 33.714-101.143 58.286-158.857 73.143-15.429 4-32 6.857-49.143 9.143h-1.714c-8.571 0-16.571-6.857-18.286-16.571v0c-2.286-10.857 5.143-17.714 11.429-25.143 22.286-25.143 47.429-47.429 66.857-94.857-92.571-53.714-152-136.571-152-229.143 0-161.714 180-292.571 402.286-292.571s402.286 130.857 402.286 292.571zM1024 585.143c0 93.143-59.429 175.429-152 229.143 19.429 47.429 44.571 69.714 66.857 94.857 6.286 7.429 13.714 14.286 11.429 25.143v0c-2.286 10.286-10.857 17.714-20 16.571-17.143-2.286-33.714-5.143-49.143-9.143-57.714-14.857-111.429-39.429-158.857-73.143-32 5.714-65.714 9.143-100.571 9.143-103.429 0-198.286-28.571-269.714-75.429 16.571 1.143 33.714 2.286 50.286 2.286 122.857 0 238.857-35.429 327.429-99.429 95.429-69.714 148-164 148-266.286 0-29.714-4.571-58.857-13.143-86.857 96.571 53.143 159.429 137.714 159.429 233.143z"></path></svg>';
	$telegramICON ='<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1025.1702857142857 1024"><path d="M1008 6.286c12 8.571 17.714 22.286 15.429 36.571l-146.286 877.714c-1.714 10.857-8.571 20-18.286 25.714-5.143 2.857-11.429 4.571-17.714 4.571-4.571 0-9.143-1.143-13.714-2.857l-258.857-105.714-138.286 168.571c-6.857 8.571-17.143 13.143-28 13.143-4 0-8.571-0.571-12.571-2.286-14.286-5.143-24-18.857-24-34.286v-199.429l493.714-605.143-610.857 528.571-225.714-92.571c-13.143-5.143-21.714-17.143-22.857-31.429-0.571-13.714 6.286-26.857 18.286-33.714l950.857-548.571c5.714-3.429 12-5.143 18.286-5.143 7.429 0 14.857 2.286 20.571 6.286z"></path></svg>';

	
 	// Construct Social Media URLs
  	$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$socialURL;
	$twitterURL = 'https://twitter.com/intent/tweet?text='.$socialTitle.'&amp;url='.$socialURL;
	$pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$socialURL.'&amp;media='.$socialThumbnail[0].'&amp;description='.$socialTitle;
	$linkedinURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$socialURL.'&amp;title='.$socialTitle;
	$whatsappURL = 'https://wa.me/?text='.$socialTitle.' '.$socialURL;
	$smsURL ='sms:?&amp;body=' .$socialURL;
	$telegramURL = 'https://t.me/share/url?url='.$socialURL.'&text='.$socialTitle;
	

	// Construct output of the social share content
	$content .= '<!-- Social Share --><div id="social-share" class="social-share-buttons '.$ss_atts['position'].'"> <span class="ss-title">'.$ss_atts['title'].'</span>';
	
	if ( $ss_atts['facebook'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-facebook" href="'.$facebookURL.'" title="Share on Facebook" target="_blank" rel="nofollow noopener noreferrer" class="ss-button facebook"><span class="ss-service-icon">'.$facebookICON.' </span><span class="ss-service-label">Share</span></a>';
	}

	if ( $ss_atts['twitter'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-twitter" href="'. $twitterURL .'" title="Share on Twitter" target="_blank" rel="nofollow noopener noreferrer" class="ss-button twitter"><span class="ss-service-icon">'.$twitterICON.' </span><span class="ss-service-label">Tweet</span></a>';
	}

	if ( $ss_atts['pinterest'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-pinterest" href="'.$pinterestURL.'" data-pin-custom="true" title="Share on Pinterest" target="_blank" rel="nofollow noopener noreferrer" class="ss-button pinterest"><span class="ss-service-icon">'.$pinterestICON.' </span><span class="ss-service-label">Pin</span></a>';
	}

	if ( $ss_atts['linkedin'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-linkedin" href="'.$linkedinURL.'" title="Share on LinkedIn" target="_blank" rel="nofollow noopener noreferrer" class="ss-button linkedin"><span class="ss-service-icon">'.$linkedinICON.' </span><span class="ss-service-label">Share</span></a>';
	}

	if ( $ss_atts['whatsapp'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-whatsapp" href="'.$whatsappURL.'" title="Share on Whatsapp" target="_blank" rel="nofollow noopener noreferrer" class="ss-button whatsapp"><span class="ss-service-icon">'.$whatsappICON.' </span><span class="ss-service-label">Whatsapp</span></a>';
	}

	if ( $ss_atts['sms'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-sms" href="'.$smsURL.'" title="Share in Message" target="_blank" rel="nofollow noopener noreferrer" class="ss-button sms"><span class="ss-service-icon">'.$smsICON.' </span><span class="ss-service-label">SMS</span></a>';
	}

	if ( $ss_atts['telegram'] !== "hide") {
		$content .= '<a class="ss-link '.$ss_atts['style'].' ss-telegram" href="'.$telegramURL.'" title="Share on Telegram" target="_blank" rel="nofollow noopener noreferrer" class="ss-button telegram"><span class="ss-service-icon">'.$telegramICON.' </span><span class="ss-service-label">Telegram</span></a>';
	}

	$content .= '</div>';
		
		return $content;
}
