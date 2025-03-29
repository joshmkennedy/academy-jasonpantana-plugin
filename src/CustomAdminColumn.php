<?php

namespace JP;

use WP_Post;

class CustomAdminColumn {
    private string $renderHook;
    private string $addColumnHook;
    public function __construct(
        private string $postType,
        private string $columnSlug,
        private string $columnTitle,
        private int $position = -1,
    ) {
        if ($this->postType === 'post') {
            $this->addColumnHook = 'manage_posts_columns';
            $this->renderHook = 'manage_posts_custom_column';
        } else {
            $this->addColumnHook = "manage_{$this->postType}_posts_columns";
            $this->renderHook = "manage_{$this->postType}_posts_custom_column";
        }
    }

    public function register(): void {
        add_filter($this->addColumnHook, [$this, 'add_column'], 10);
        add_action($this->renderHook, function (string $column, int $postId) {
            if ($column === $this->columnSlug) {
                $this->render($column, $postId);
            }
        }, 10, 2);
    }

    /**
     * @param array<string,string> $columns 
     * @return array<string,string>
     */
    public function add_column(array $columns): array {
        if ($this->position === -1) {
            $this->position = count($columns);
        }

        $i = 0;
        $results = [];
        foreach ($columns as $key => $value) {
            $results[$key] = $value;
            $i++;
            if ($i === $this->position) {
                $results[$this->columnSlug] = $this->columnTitle;
            }
        }

        return $results;
    }

    public function render(string $column, int  $postId): void {
?>
        <p>Implement the render method for this column</p>
<?php
    }
}
