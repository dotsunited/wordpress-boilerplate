<div class="w-full mx-auto p-4 flex md:hidden flex-row flex-wrap items-center justify-between">
    <div class="w-full flex flex-row gap-4 justify-between items-center overflow-hidden">
        <a href="<?= esc_attr(get_home_url()); ?>" title="Back to frontpage" class="inline-block">
            <span class="screen-reader-text"><?= _x('Back to frontpage', 'logo', 'wordpress-boilerplate'); ?></span>
            <?= wordpress_boilerplate_asset_embed('/vendor/images/logo-dotsunited.svg'); ?>
        </a>

        <div class="off-canvas-menu" id="off-canvas-menu-target">
            <div class="">
                <button data-ctrly="off-canvas-menu-target" class="js-off-canvas-menu-control off-canvas-menu__control" title="<?= _x('Open navigation', 'button', 'wordpress-boilerplate'); ?>">
                    <span class="off-canvas-menu__control-icon" aria-hidden="true"><span></span></span>
                    <span class="hidden"><?= _x('Open navigation', 'button', 'wordpress-boilerplate'); ?></span>
                </button>
            </div>

            <section class="off-canvas-menu__target transition duration-500 ease-in-out">
                <div class="relative flex flex-col overflow-x-hidden overflow-y-auto">
                    <div class="w-full p-4">
                        <button data-ctrly="off-canvas-menu-target" class="js-off-canvas-menu-control off-canvas-menu__control off-canvas-menu__control--open" title="<?= _x('Close navigation', 'button', 'wordpress-boilerplate'); ?>">
                            <span class="off-canvas-menu__control-icon" aria-hidden="true"><span></span></span>
                            <span class="hidden"><?= _x('Close navigation', 'button', 'wordpress-boilerplate'); ?></span>
                        </button>
                    </div>

                    <nav class="off-canvas-menu__navigation">
                        <?= wordpress_boilerplate_off_canvas_menu(); ?>
                    </nav>
                </div>
            </section>
        </div>
    </div>
</div>
