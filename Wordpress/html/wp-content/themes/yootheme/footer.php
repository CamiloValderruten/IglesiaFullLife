<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

$site = $theme->get('site', []);

?>
        <?php if (!$theme->get('builder')) : ?>

                        </div>

                        <?php if (is_active_sidebar('sidebar')) : ?>
                        <?= get_view('sidebar') ?>
                        <?php endif ?>

                    </div>

                </div>
            </div>
            <?php endif ?>

            <?= get_view('section', ['name' => 'bottom']) ?>
            <?= get_builder($theme->get('footer.content'), 'footer') ?>

        <?php if ($site['layout'] == 'boxed') : ?>
            </div>
        </div>
        <?php endif ?>

        <?php wp_footer() ?>
    </body>
</html>
