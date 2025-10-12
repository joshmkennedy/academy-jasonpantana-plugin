<?php

namespace JP;

class Aim100daysModal {
    public function renderNotice() {
        $lps = new User\LearningPathSettings();
        if (!$lps || !wp_get_current_user()) return;

        // if ($aimFormDisplay::userHasActiveList(wp_get_current_user()->ID) || !$this->allowTesting()) return;
        if(!feature_flag('starting_plans')) return;
        // TODO: this will need to change as we add more lists or something
        if($lps->getActiveList()) return;

        ob_start();
?>
        <div class="jp-profile-content">
            <p class="heading">Not sure where to start?</p>
            <p>Get currated content, delivered right to your inbox designed to get you up to speed and to meet you where you are!</p>
        </div>
        <div>
            <button class="notice-action" data-action="open-aim-100-days">Find your startng point</button>
        </div>
        <?= $this->renderModal(); ?>
    <?php return ob_get_clean();
    }

    /**
     * Allow testing and viewing of this banner 
     * if the user is admin and param is set to test
     **/
    public function allowTesting(): bool {
        $status = !user_can(wp_get_current_user(), 'manage_options') || !isset($_GET['test']);
        return $status;
    }

    private function renderModal() {
        $formId = get_option('aim_form_100days_id') ?: 21185;
        if (!$formId) return;

        ob_start();

    ?>
        <dialog id="aim-100-days" class="aim-100-days notice-triggered-modal">
            <header class="notice-modal-modal-header">
                <h3>Answer a few questions to get started</h3>
                <form method="dialog" class="modal-close-form">
                    <button class="aim-100-days__close modal-close">
                        <?= dumpSvg('close'); ?>
                    </button>
                </form>
            </header>

            <div class="long-form-modal-content">
                <?= do_shortcode("[forminator_form id=$formId]"); ?>
            </div>
        </dialog>
<?php
        return ob_get_clean();
    }
}
