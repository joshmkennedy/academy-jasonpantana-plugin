<?php

use JP\User\LearningPathSettings;

get_header();
$tutil = new \JP\JPTemplate;
$learningPathSettings = new LearningPathSettings();
$emailsRecieved = [];
$listId = "1";
$subscribedOn = "2022-10-01";

?>

<?= var_dump($learningPathSettings->getLists()); ?>
<div class="aim-search-template aim-template aim-clip-template">
    <!-- HEADER -->
    <div class="aim-template-header" style="--bg-image: url(<?= getAimAssetUrl('green-gradient.webp'); ?>);">
        <div class="aim-template-header__content">
            <a href="/profile" class="aim-template-header__content__back-link" style="color:white; text-decoration:none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="max-width:1em;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Back to Profile
            </a>
            <div class="title">
                <span style="font-size:.5em;">Subscribed Learning Path</span>
                <h1>
                    Settings
                </h1>
            </div>
        </div>
        <?php include $tutil->useTemplate('utils/circutry-graphic'); ?>
    </div>
    <!-- CONTENT -->
    <div class="aim-template-content">
        <div class="aim-template-content__page">
            <div class="aim-user-settings__layout">
                <div class="aim-user-settings__layout__left">
                    <h2 class="aim-user-settings__section-title">Weekly Videos Recieved</h2>
                    <ul class="aim-user-settings__list">
                        <?php foreach ($emailsRecieved as $email): ?>
                            <li class="aim-user-settings__list-item">
                                <a href="<?= $email->link; ?>" class="aim-user-settings__list-item-link">
                                    <?= $email->week; ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="aim-user-settings__layout__right">
                    <p>Subscribed on <?= $subscribedOn; ?></p>
                    <button class="btn btn--secondary" data-action="unsubscribe" data-list-id="<?= $listId; ?>">Unsubscribe</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
