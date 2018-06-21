<?php
if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<aside  class="w-auto lg:w-1/4" id="secondary" role="complementary">
    <?php dynamic_sidebar('sidebar-1'); ?>
</aside>
