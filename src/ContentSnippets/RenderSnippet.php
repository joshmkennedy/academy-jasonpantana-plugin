<?php

namespace JP\ContentSnippets;

class RenderSnippet {
    public $snippet;
    public function __construct(private string|int $snippet_id) {
        if (is_int($this->snippet_id)) {
            $this->snippet = get_post($this->snippet_id);
        } else {
            $this->snippet = get_page_by_path($this->snippet_id, OBJECT, 'content-snippet');
        }
        if (!$this->snippet) {
            error_log("no snippet found for $this->snippet_id");
        }
    }

    public function render(): string|null {
        if (!$this->snippet) {
            if (current_user_can('edit_posts')) {
                return "no snippet found for $this->snippet_id";
            }
            return null;
        }

        if(! $this->isVisible() ) return null;
        global $post;
        $post = $this->snippet;
        $content = apply_filters('the_content', $this->snippet->post_content);
        wp_reset_postdata();
        return $content;
    }

    private function isVisible(): bool {
        if (current_user_can('edit_posts')) {
            return true;
        }
        if (!$this->snippet) return false;

        if ($this->snippet->post_status === 'publish') {
            return true;
        }

        return false;
    }
}
