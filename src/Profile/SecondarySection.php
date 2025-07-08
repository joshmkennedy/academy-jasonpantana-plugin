<?php

namespace JP\Profile;


/** @package JP\Profile */
class SecondarySection extends Lolole {
    public function __construct() {
        parent::__construct();
    }

    public function render(): void {
?>
        <div class="lolole-wrapper alt-wrapper">
            <?php
            $this->renderTagCloudSection(
                title: 'Tools to Test',
                term: get_term_by("slug", "tools", "ld_lesson_category"),
                cardCB: fn($args) => $this->toolTag($args),
            );

            $this->renderLessonsSection(
                title: 'Intro to AI',
                programId: 1294,
                cardCB: fn($lesson, $programId) => $this->essentialCard($lesson, $programId),
            );
            ?>
        </div>
<?php

    }
}
