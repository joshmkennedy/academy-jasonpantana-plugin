<?php

namespace JP;

class WalkthroughBanner {

	// cookies to check
	const USER_HAS_DISMISSED_BEFORE = "walkthrough-banner-temp-dismissed--flag";
	const DONT_SHOW_BANNER = "walkthrough-banner-temp-dismissed";

	public function __construct() {
	}

	public function render($atts): string {
		// DONT SHOW IF USER HAS DISSMISSED SETTINGS
		if (get_user_meta( get_current_user_id(), 'walkthrough-banner-dismissed', "true")
			|| $_COOKIE[self::DONT_SHOW_BANNER]
		) {
			return '';
		}
		$atts = shortcode_atts([
			'embed' => 'https://player.vimeo.com/video/1087246747?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479',
			'heading' => 'Take a tour',
			'content' => 'Take a tour of AI Marketing Academy',
			'button_text' => 'Watch Video',
		], $atts);
		ob_start();
?>
		<div class="walkthrough-banner__banner">
			<button class="walkthrough-banner__close">
				<?= dumpSvg('close'); ?>
			</button>
			<div class="walkthrough-banner__content">
				<!-- <h2 class="walkthrough-banner__heading"><?= $atts['heading']; ?></h2> -->
				<button class="walkthrough-banner__cta"><?= $atts['content']; ?></button>
				<!-- <button class="walkthrough-banner__button"> -->
				<!-- 	<?= dumpSvg('play'); ?> -->
				<!-- 	<span class="walkthrough-banner__button-text"> -->
				<!-- 		<?= $atts['button_text']; ?> -->
				<!-- 	</span> -->
				<!-- </button> -->
			</div>
		</div>

		<dialog id="walkthrough-banner__popup" class="walkthrough-banner__popup" >
			<button class="walkthrough-popup__close">
				<?= dumpSvg('close'); ?>
			</button>
			<iframe style="width:100%; aspect-ratio:16 / 9;" src="<?= $atts["embed"]; ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="AiM Walkthrough Video"></iframe>
			<script src="https://player.vimeo.com/api/player.js"></script>
		</dialog>
<?php
		return ob_get_clean();
	}

	public function handleUserDismiss() {
		$user = wp_get_current_user();	
		if (!$user) return;

		update_user_meta($user->ID, 'walkthrough-banner-dismissed', "true");
		wp_send_json_success(['message'=>'Dismissed']);
		die();
	}
}
