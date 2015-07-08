<?php
/**
 * Subsidiary Menu Template
 *
 * Displays the Subsidiary Menu if it has active menu items.
 *
 * @package MyLife
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2011 - 2013, Justin Tadlock
 * @link http://themehybrid.com/themes/my-life
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( has_nav_menu( 'subsidiary' ) ) : ?>

	<?php do_atomic( 'before_menu_subsidiary' ); // my-life_before_menu_subsidiary ?>

	<div id="menu-subsidiary" class="menu-container">

		<div class="wrap">

			<?php do_atomic( 'open_menu_subsidiary' ); // my-life_open_menu_subsidiary ?>

			<?php wp_nav_menu( array( 'theme_location' => 'subsidiary', 'container_class' => 'menu', 'menu_class' => '', 'menu_id' => 'menu-subsidiary-items', 'depth' => 1, 'fallback_cb' => '' ) ); ?>

			<?php do_atomic( 'close_menu_subsidiary' ); // my-life_close_menu_subsidiary ?>

		</div>

	</div><!-- #menu-subsidiary .menu-container -->

	<?php do_atomic( 'after_menu_subsidiary' ); // my-life_after_menu_subsidiary ?>

<?php endif; ?>