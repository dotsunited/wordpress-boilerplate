<?php
if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside class="col-span-full lg:col-span-1 space-y-8" id="secondary" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
