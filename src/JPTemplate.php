<?php

namespace JP;

class JPTemplate {
    private string $templateDirPath;
    public function __construct() {
        $this->templateDirPath = \JP_PLUGIN_ROOT_DIR_PATH . 'templates';
    }


    /**
     * @param array<string, string> $config
     * @return bool 
     * //param array{post_type:?string, taxonomy:?string, term:?string} $config
     */
    public function onArchive(array $config): bool {
        if (isset($config['term']) && isset($config['taxonomy'])) {
            return \is_tax($config['taxonomy'], $config['term']);
        }
        if (isset($config['taxonomy'])) {
            return \is_tax($config['taxonomy']);
        }
        if (isset($config['post_type'])) {
            return \is_post_type_archive($config['post_type']);
        }
        return false;
    }

    /**
     * Checks if the current page is on a single post for specific post type
     * TODO: extend for doing taxonomies and terms of certain taxonomy
     *
     * @param array<string, string> $config 
     * @return bool 
     */
    public function onSingle(array $config): bool {
        if (isset($config['post_type'])) {
            return \is_singular($config['post_type']);
        }
        return false;
    }

    public function useTemplate(string $slug): string|null {
        $templatePath = $this->templateDirPath . '/' . $slug . '.php';
        if (file_exists($templatePath)) {
            return $templatePath;
        }
        error_log("template not found: $templatePath");
        return null;
    }
}
