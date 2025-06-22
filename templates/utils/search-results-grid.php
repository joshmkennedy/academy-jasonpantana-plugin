<?php if (have_posts()): ?>
    <div class="lesson-grid">
        <?php while (have_posts()): the_post(); ?>
            <?php $card = new \JP\SearchCard(get_post());
            $card->render(); ?>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <div class="no-results">
        <h2>No results found</h2>
        <p>Try searching for something else</p>
    </div>
<?php endif; ?>
