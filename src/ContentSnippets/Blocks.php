<?php

namespace JP\ContentSnippets;

class Blocks {

	public function __construct(private string $blocks_dir) {
	}

	public function register(): void {
		$blocks = $this->get_blocks();
		foreach ( $blocks as $block_dir ) {
			$block_json = $block_dir . '/block.json';
			if ( file_exists( $block_json ) ) {
				// register_block_type( $block_dir );
			}
		}
	}

	private function get_blocks(): array {
		if ( ! is_dir( $this->blocks_dir ) ) {
			return [];
		}

		$blocks = [];
		$items  = scandir( $this->blocks_dir );

		if ( ! $items ) {
			return [];
		}

		foreach ( $items as $item ) {
			if ( '.' === $item || '..' === $item ) {
				continue;
			}

			$path = $this->blocks_dir . '/' . $item;
			if ( is_dir( $path ) ) {
				$blocks[] = $path;
			}
		}

		return $blocks;
	}
}
