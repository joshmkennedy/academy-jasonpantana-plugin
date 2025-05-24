<?php

namespace JP;

class WalkthroughBanner {


	public function __construct() {
	}

	public function render($atts): string {
		$atts = shortcode_atts([
			'embed' => 'https://player.vimeo.com/video/1087246747?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479',
			'heading' => 'Take a tour',
			'content' => 'Watch a quick video to get the most of Ai Marketing Academy.',
			'button_text' => 'Watch Video',
		], $atts);
		ob_start();
?>
		<div class="walkthrough-banner__banner">
			<button class="walkthrough-banner__close">
				<?= dumpSvg('close'); ?>
			</button>
			<div class="walkthrough-banner__content">
				<h2 class="walkthrough-banner__heading"><?= $atts['heading']; ?></h2>
				<p class="walkthrough-banner__text"><?= $atts['content']; ?></p>
				<button class="walkthrough-banner__button">
					<?= dumpSvg('play'); ?>
					<span class="walkthrough-banner__button-text">
						<?= $atts['button_text']; ?>
					</span>
				</button>
			</div>
		</div>

		<dialog id="walkthrough-banner__popup" class="walkthrough-banner__popup" open>
			<iframe style="width:100%; aspect-ratio:16 / 9;" src="<?= $atts["embed"]; ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture; clipboard-write; encrypted-media" style="position:absolute;top:0;left:0;width:100%;height:100%;" title="AiM Walkthrough Video"></iframe>
			<script src="https://player.vimeo.com/api/player.js"></script>
		</dialog>
<?php
		return ob_get_clean();
	}
}
