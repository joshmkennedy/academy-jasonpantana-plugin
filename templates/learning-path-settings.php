<?php

use JP\User\LearningPathSettings;

get_header();
$tutil = new \JP\JPTemplate;
$learningPathSettings = new LearningPathSettings();
$activeList = $learningPathSettings->getActiveList();

$listId = (is_array($activeList) && array_key_exists("listId", $activeList)) ? $activeList["listId"] : null;
$subscribedOn = $listId ? date("F j, Y", $activeList['meta']["subscribed_on"]) : null;
$emailsRecieved = $listId ? $learningPathSettings->getReceivedEmailsForList($listId) : [];

?>

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
                <span style="font-size:.5em;">Subscribed Fast Track</span>
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
            <?php if ($listId): ?>
                <div class="aim-user-settings__layout">
                    <div class="aim-user-settings__layout__left">
                        <h2 class="aim-user-settings__section-title">Weekly Videos Recieved</h2>

                        <?php if (count($emailsRecieved) === 0): ?>
                            <p style="color: var(--slate-800); margin-block: .25em">All recieved content will be saved here so you can access it later.</p>
                            <p style="color: var(--slate-500); margin-block: .25em">You havent recieved any weekly content yet.</p>
                        <?php endif; ?>
                        <ul class="aim-user-settings__list">
                            <?php foreach ($emailsRecieved as $email): ?>
                                <li class="aim-user-settings__list-item">
                                    <a href="<?= $email['link']; ?>" class="aim-user-settings__list-item-link">
                                        <span><?= date("F j, Y", strtotime($email['sentDate'])); ?></span>
                                        <span style="max-width:.5em; fill: currentColor;" class="list-item-icon">
                                            <?= dumpSvg('chevron-right'); ?>
                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>


                    <div class="aim-user-settings__layout__right">
                        <p>Subscribed on <?= $subscribedOn; ?></p>
                        <button class="btn btn--secondary" data-action="unsubscribe" data-list-id="<?= $listId; ?>">Stop this Track</button>
                    </div>
                </div>
            <?php else: ?>
                <div class="aim-user-settings__layout">
                    <div class="aim-user-settings__layout__left">
                        <h2 class="aim-user-settings__section-title">No Active Fast Tracks Found</h2>
                        <a href="/profile" class="aim-template-header__content__back-link" style="color:var(--brand-c-primary); text-decoration:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" style="max-width:1em;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Back to Profile
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
get_footer();
