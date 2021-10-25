<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Generates and outputs theme options' generated styleshets
 *
 * @action Before the template: us_before_template:templates/theme-options.css
 * @action After the template: us_after_template:templates/theme-options.css
 */

$prefixes = array( 'heading', 'body', 'menu' );
$font_families = array();
$default_font_weights = array_fill_keys( $prefixes, 400 );
foreach ( $prefixes as $prefix ) {
	$font = explode( '|', us_get_option( $prefix . '_font_family', 'none' ), 2 );
	if ( $font[0] == 'none' ) {
		// Use the default font
		$font_families[ $prefix ] = '';
	} elseif ( strpos( $font[0], ',' ) === FALSE ) {
		// Use some specific font from Google Fonts
		if ( ! isset( $font[1] ) OR empty( $font[1] ) ) {
			// Fault tolerance for missing font-variants
			$font[1] = '400,700';
		}
		// The first active font-weight will be used for "normal" weight
		$default_font_weights[ $prefix ] = intval( $font[1] );
		$fallback_font_family = us_config( 'google-fonts.' . $font[0] . '.fallback', 'sans-serif' );
		$font_families[ $prefix ] = 'font-family: "' . $font[0] . '", ' . $fallback_font_family . ";\n";
	} else {
		// Web-safe font combination
		$font_families[ $prefix ] = 'font-family: ' . $font[0] . ";\n";
	}
}

?>

<?php if ( FALSE ): ?><style>/* Setting IDE context */<?php endif; ?>


/* Typography
   ========================================================================== */

body {
	<?php echo $font_families['body'] ?>
	font-size: <?php echo us_get_option( 'body_fontsize' ) ?>px;
	line-height: <?php echo us_get_option( 'body_lineheight' ) ?>px;
	font-weight: <?php echo $default_font_weights['body'] ?>;
	}
.w-blog.layout_grid .w-blog-post,
.w-blog.layout_latest .w-blog-post {
	font-size: <?php echo us_get_option( 'body_fontsize' ) ?>px;
	}

.l-header .menu-item-language,
.l-header .w-nav-item {
	<?php echo $font_families['menu'] ?>
	font-weight: <?php echo $default_font_weights['menu'] ?>;
	}
.type_desktop .menu-item-language > a,
.l-header .type_desktop .w-nav-anchor.level_1,
.type_desktop [class*="columns"] .menu-item-has-children .w-nav-anchor.level_2 {
	font-size: <?php echo us_get_option( 'menu_fontsize' ) ?>px;
	}
.type_desktop .submenu-languages .menu-item-language > a,
.l-header .type_desktop .w-nav-anchor.level_2,
.l-header .type_desktop .w-nav-anchor.level_3,
.l-header .type_desktop .w-nav-anchor.level_4 {
	font-size: <?php echo us_get_option( 'menu_sub_fontsize' ) ?>px;
	}
.l-header .type_mobile .w-nav-anchor.level_1 {
	font-size: <?php echo us_get_option( 'menu_fontsize_mobile' ) ?>px;
	}
.type_mobile .menu-item-language > a,
.l-header .type_mobile .w-nav-anchor.level_2,
.l-header .type_mobile .w-nav-anchor.level_3,
.l-header .type_mobile .w-nav-anchor.level_4 {
	font-size: <?php echo us_get_option( 'menu_sub_fontsize_mobile' ) ?>px;
	}

h1, h2, h3, h4, h5, h6,
.w-blog-post.format-quote blockquote,
.w-counter-number,
.w-logo-title,
.w-pricing-item-price,
.w-tabs-item-title,
.ult_price_figure,
.ult_countdown-amount,
.ultb3-box .ultb3-title,
.stats-block .stats-desc .stats-number {
	<?php echo $font_families['heading'] ?>
	font-weight: <?php echo $default_font_weights['heading'] ?>;
	}
h1 {
	font-size: <?php echo us_get_option( 'h1_fontsize' ) ?>px;
	}
h2 {
	font-size: <?php echo us_get_option( 'h2_fontsize' ) ?>px;
	}
h3,
.w-actionbox h2 {
	font-size: <?php echo us_get_option( 'h3_fontsize' ) ?>px;
	}
h4,
.w-blog.layout_latest .w-blog-post-title,
.widgettitle,
.comment-reply-title,
.woocommerce #reviews h2,
.woocommerce .related > h2,
.woocommerce .upsells > h2,
.woocommerce .cross-sells > h2,
.ultb3-box .ultb3-title,
.flip-box-wrap .flip-box .ifb-face h3,
.aio-icon-box .aio-icon-header h3.aio-icon-title {
	font-size: <?php echo us_get_option( 'h4_fontsize' ) ?>px;
	}
h5,
.w-blog.layout_grid .w-blog-post-title,
.w-blog.layout_masonry .w-blog-post-title {
	font-size: <?php echo us_get_option( 'h5_fontsize' ) ?>px;
	}
h6 {
	font-size: <?php echo us_get_option( 'h6_fontsize' ) ?>px;
	}
@media (max-width: 767px) {
body {
	font-size: <?php echo us_get_option( 'body_fontsize_mobile' ) ?>px;
	line-height: <?php echo us_get_option( 'body_lineheight_mobile' ) ?>px;
	}
h1 {
	font-size: <?php echo us_get_option( 'h1_fontsize_mobile' ) ?>px;
	}
h2 {
	font-size: <?php echo us_get_option( 'h2_fontsize_mobile' ) ?>px;
	}
h3 {
	font-size: <?php echo us_get_option( 'h3_fontsize_mobile' ) ?>px;
	}
h4,
.w-blog.layout_latest .w-blog-post-title,
.widgettitle,
.comment-reply-title,
.woocommerce #reviews h2,
.woocommerce .related > h2,
.woocommerce .upsells > h2,
.woocommerce .cross-sells > h2,
.ultb3-box .ultb3-title,
.flip-box-wrap .flip-box .ifb-face h3,
.aio-icon-box .aio-icon-header h3.aio-icon-title {
	font-size: <?php echo us_get_option( 'h4_fontsize_mobile' ) ?>px;
	}
h5,
.w-blog.layout_grid .w-blog-post-title,
.w-blog.layout_masonry .w-blog-post-title {
	font-size: <?php echo us_get_option( 'h5_fontsize_mobile' ) ?>px;
	}
h6 {
	font-size: <?php echo us_get_option( 'h6_fontsize_mobile' ) ?>px;
	}
}

/* Layout Options
   ========================================================================== */

.l-body,
.l-header.pos_fixed {
	min-width: <?php echo us_get_option( 'site_canvas_width' ) ?>px;
	}
.l-canvas.type_boxed,
.l-canvas.type_boxed .l-subheader,
.l-canvas.type_boxed ~ .l-footer .l-subfooter {
	max-width: <?php echo us_get_option( 'site_canvas_width' ) ?>px;
	}
.l-subheader-h,
.l-titlebar-h,
.l-main-h,
.l-section-h,
.l-subfooter-h,
.w-tabs-section-content-h,
.w-blog-post-body {
	max-width: <?php echo us_get_option( 'site_content_width' ) ?>px;
	}
.l-sidebar {
	width: <?php echo us_get_option( 'sidebar_width' ) ?>%;
	}
.l-content {
	width: <?php echo us_get_option( 'content_width' ) ?>%;
	}
@media (max-width: <?php echo us_get_option( 'columns_stacking_width' ) ?>px) {
.g-cols.offset_none,
.g-cols.offset_none > div {
	display: block;
	}
.g-cols > div {
	width: 100% !important;
	margin-left: 0 !important;
	margin-right: 0 !important;
	margin-bottom: 30px;
	}
.l-subfooter.at_top .g-cols > div {
	margin-bottom: 10px;
	}
.g-cols.offset_none > div,
.g-cols > div:last-child {
	margin-bottom: 0 !important;
	}
}

/* Header Options
   ========================================================================== */

@media (min-width: <?php echo us_get_option('responsive_layout') ? '901px' : '300px' ?>) {
.l-subheader.at_middle {
	line-height: <?php echo us_get_option( 'header_main_height' ) ?>px;
	}
.l-header.layout_advanced .l-subheader.at_middle,
.l-header.layout_centered .l-subheader.at_middle {
	height: <?php echo us_get_option( 'header_main_height' ) ?>px;
	}
.l-header.layout_standard.sticky .l-subheader.at_middle,
.l-header.layout_extended.sticky .l-subheader.at_middle {
	line-height: <?php echo us_get_option( 'header_main_sticky_height_1' ) ?>px;
	}
.l-header.layout_advanced.sticky .l-subheader.at_middle,
.l-header.layout_centered.sticky .l-subheader.at_middle {
	line-height: <?php echo us_get_option( 'header_main_sticky_height_2' ) ?>px;
	height: <?php echo us_get_option( 'header_main_sticky_height_2' ) ?>px;
	}
.l-subheader.at_top {
	height: <?php echo us_get_option( 'header_extra_height' ) ?>px;
	}
.l-subheader.at_top,
.l-subheader.at_bottom {
	line-height: <?php echo us_get_option( 'header_extra_height' ) ?>px;
	}
.l-header.layout_extended.sticky .l-subheader.at_top {
	line-height: <?php echo us_get_option( 'header_extra_sticky_height_1' ) ?>px;
	height: <?php echo us_get_option( 'header_extra_sticky_height_1' ) ?>px;
	}
.l-header.layout_advanced.sticky .l-subheader.at_bottom,
.l-header.layout_centered.sticky .l-subheader.at_bottom {
	line-height: <?php echo us_get_option( 'header_extra_sticky_height_2' ) ?>px;
	}
.l-header.layout_standard.pos_fixed ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_standard.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_standard.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_standard.pos_fixed ~ .l-main .l-section:first-child,
.l-header.layout_standard.pos_static.bg_transparent ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_standard.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_standard.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_standard.pos_static.bg_transparent ~ .l-main .l-section:first-child {
	padding-top: <?php echo us_get_option( 'header_main_height' ) ?>px;
	}
.l-header.layout_extended.pos_fixed ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_extended.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_extended.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_extended.pos_fixed ~ .l-main .l-section:first-child,
.l-header.layout_extended.pos_static.bg_transparent ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_extended.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_extended.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_extended.pos_static.bg_transparent ~ .l-main .l-section:first-child {
	padding-top: <?php echo us_get_option( 'header_main_height' ) + us_get_option( 'header_extra_height' ) ?>px;
	}
.l-header.layout_advanced.pos_fixed ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_advanced.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_advanced.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_advanced.pos_fixed ~ .l-main .l-section:first-child,
.l-header.layout_advanced.pos_static.bg_transparent ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_advanced.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_advanced.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_advanced.pos_static.bg_transparent ~ .l-main .l-section:first-child {
	padding-top: <?php echo us_get_option( 'header_main_height' ) + us_get_option( 'header_extra_height' ) ?>px;
	}
.l-header.layout_centered.pos_fixed ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_centered.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_centered.pos_fixed ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_centered.pos_fixed ~ .l-main .l-section:first-child,
.l-header.layout_centered.pos_static.bg_transparent ~ .l-titlebar,
.l-canvas.titlebar_none.sidebar_left .l-header.layout_centered.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_right .l-header.layout_centered.pos_static.bg_transparent ~ .l-main,
.l-canvas.titlebar_none.sidebar_none .l-header.layout_centered.pos_static.bg_transparent ~ .l-main .l-section:first-child {
	padding-top: <?php echo us_get_option( 'header_main_height' ) + us_get_option( 'header_extra_height' ) ?>px;
	}
.l-body.header_aside {
	padding-left: <?php echo us_get_option( 'header_main_width' ) ?>px;
	position: relative;
	}
.rtl.l-body.header_aside {
	padding-left: 0;
	padding-right: <?php echo us_get_option( 'header_main_width' ) ?>px;
	}
.l-header.layout_sided,
.l-header.layout_sided .w-cart-notification {
	width: <?php echo us_get_option( 'header_main_width' ) ?>px;
	}
.l-body.header_aside .l-navigation-item.to_next {
	left: <?php echo us_get_option( 'header_main_width' ) - 200 ?>px;
	}
.no-touch .l-body.header_aside .l-navigation-item.to_next:hover {
	left: <?php echo us_get_option( 'header_main_width' ) ?>px;
	}
.rtl.l-body.header_aside .l-navigation-item.to_next {
	right: <?php echo us_get_option( 'header_main_width' ) - 200 ?>px;
	}
.no-touch .rtl.l-body.header_aside .l-navigation-item.to_next:hover {
	right: <?php echo us_get_option( 'header_main_width' ) ?>px;
	}
.w-nav.layout_ver.type_desktop [class*="columns"] .w-nav-list.level_2 {
    width: calc(100vw - <?php echo us_get_option( 'header_main_width' ) ?>px);
	max-width: 980px;
	}
}

/* Menu Options
   ========================================================================== */

.w-nav.type_desktop .w-nav-anchor.level_1 {
	padding: 0 <?php echo us_get_option( 'menu_indents' )/2 ?>px;
	}
.w-nav.type_desktop .btn.w-nav-item.level_1 {
	margin: 0 <?php echo us_get_option( 'menu_indents' )/4 ?>px;
	}
.rtl .w-nav.type_desktop .btn.w-nav-item.level_1:last-child {
	margin-right: <?php echo us_get_option( 'menu_indents' )/4 ?>px;
	}
.l-header.layout_sided .w-nav.type_desktop {
	line-height: <?php echo us_get_option( 'menu_indents' ) ?>px;
	}

/* Logo Options
   ========================================================================== */

@media (min-width: 901px) {
.w-logo-img {
	height: <?php echo min(us_get_option( 'logo_height' ), us_get_option( 'header_main_height' )) ?>px;
	}
.w-logo.with_transparent .w-logo-img > img.for_default {
	margin-bottom: -<?php echo min(us_get_option( 'logo_height' ), us_get_option( 'header_main_height' )) ?>px;
	}
.l-header.layout_standard.sticky .w-logo-img,
.l-header.layout_extended.sticky .w-logo-img {
	height: <?php echo min(us_get_option( 'logo_height_sticky' ), us_get_option( 'header_main_sticky_height_1' )) ?>px;
	}
.l-header.layout_standard.sticky .w-logo.with_transparent .w-logo-img > img.for_default,
.l-header.layout_extended.sticky .w-logo.with_transparent .w-logo-img > img.for_default {
	margin-bottom: -<?php echo min(us_get_option( 'logo_height_sticky' ), us_get_option( 'header_main_sticky_height_1' )) ?>px;
	}
.l-header.layout_advanced.sticky .w-logo-img,
.l-header.layout_centered.sticky .w-logo-img {
	height: <?php echo min(us_get_option( 'logo_height_sticky' ), us_get_option( 'header_main_sticky_height_2' )) ?>px;
	}
.l-header.layout_advanced.sticky .w-logo.with_transparent .w-logo-img > img.for_default,
.l-header.layout_centered.sticky .w-logo.with_transparent .w-logo-img > img.for_default {
	margin-bottom: -<?php echo min(us_get_option( 'logo_height_sticky' ), us_get_option( 'header_main_sticky_height_2' )) ?>px;
	}
.l-header.layout_sided .w-logo-img > img {
	width: <?php echo min(us_get_option( 'logo_width' ), us_get_option( 'header_main_width' )) ?>px;
	}
.w-logo-title {
	font-size: <?php echo us_get_option( 'logo_font_size' ) ?>px;
	}
}
@media (min-width: 601px) and (max-width: 900px) {
.w-logo-img {
	height: <?php echo us_get_option( 'logo_height_tablets' ) ?>px;
	}
.w-logo.with_transparent .w-logo-img > img.for_default {
	margin-bottom: -<?php echo us_get_option( 'logo_height_tablets' ) ?>px;
	}
.w-logo-title {
	font-size: <?php echo us_get_option( 'logo_font_size_tablets' ) ?>px;
	}
}
@media (max-width: 600px) {
.w-logo-img {
	height: <?php echo us_get_option( 'logo_height_mobiles' ) ?>px;
	}
.w-logo.with_transparent .w-logo-img > img.for_default {
	margin-bottom: -<?php echo us_get_option( 'logo_height_mobiles' ) ?>px;
	}
.w-logo-title {
	font-size: <?php echo us_get_option( 'logo_font_size_mobiles' ) ?>px;
	}
}
/* Color Styles
   ========================================================================== */

/* Header Socials Custom color */
.l-header .w-socials-item.custom .w-socials-item-link-hover {
	background-color: <?php echo us_get_option( 'header_socials_custom_color' ) ?>;
	}

/* Body Background Color */
.l-body {
	background-color: <?php echo us_get_option( 'color_body_bg' ) ?>;
	}

/*************************** HEADER ***************************/

/* Header Background Color */
.l-subheader.at_middle,
.l-subheader.at_middle .w-lang-list,
.l-subheader.at_middle .type_mobile .w-nav-list.level_1 {
	background-color: <?php echo us_get_option( 'color_header_bg' ) ?>;
	}

/* Header Text Color */
.l-subheader.at_middle,
.transparent .l-subheader.at_middle .type_mobile .w-nav-list.level_1 {
	color: <?php echo us_get_option( 'color_header_text' ) ?>;
	}

/* Header Text Hover Color */
.no-touch .w-logo-link:hover,
.no-touch .l-subheader.at_middle .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_middle .w-lang-item:hover,
.no-touch .transparent .l-subheader.at_middle .w-lang.active .w-lang-item:hover,
.no-touch .l-subheader.at_middle .w-socials-item-link:hover,
.no-touch .l-subheader.at_middle .w-search-open:hover,
.no-touch .l-subheader.at_middle .w-cart-h:hover .w-cart-link,
.no-touch .l-subheader.at_middle .w-cart-quantity {
	color: <?php echo us_get_option( 'color_header_text_hover' ) ?>;
	}

/* Extended Header Background Color */
.l-subheader.at_top,
.l-subheader.at_top .w-lang-list,
.l-subheader.at_bottom,
.l-subheader.at_bottom .type_mobile .w-nav-list.level_1 {
	background-color: <?php echo us_get_option( 'color_header_ext_bg' ) ?>;
	}

/* Extended Header Text Color */
.l-subheader.at_top,
.l-subheader.at_bottom,
.transparent .l-subheader.at_bottom .type_mobile .w-nav-list.level_1,
.w-lang.active .w-lang-item {
	color: <?php echo us_get_option( 'color_header_ext_text' ) ?>;
	}

/* Extended Header Text Hover Color */
.no-touch .l-subheader.at_top .w-contacts-item-value a:hover,
.no-touch .l-subheader.at_top .w-lang-item:hover,
.no-touch .transparent .l-subheader.at_top .w-lang.active .w-lang-item:hover,
.no-touch .l-subheader.at_top .w-socials-item-link:hover,
.no-touch .l-subheader.at_bottom .w-search-open:hover,
.no-touch .l-subheader.at_bottom .w-cart-h:hover .w-cart-link,
.no-touch .l-subheader.at_bottom .w-cart-quantity {
	color: <?php echo us_get_option( 'color_header_ext_text_hover' ) ?>;
	}

/* Transparent Header Text Color */
.l-header.transparent .l-subheader {
	color: <?php echo us_get_option( 'color_header_transparent_text' ) ?>;
	}

/* Transparent Header Text Hover Color */
.no-touch .l-header.transparent .type_desktop .menu-item-language > a:hover,
.no-touch .l-header.transparent .type_desktop .menu-item-language:hover > a,
.no-touch .l-header.transparent .w-logo-link:hover,
.no-touch .l-header.transparent .l-subheader .w-contacts-item-value a:hover,
.no-touch .l-header.transparent .l-subheader .w-lang-item:hover,
.no-touch .l-header.transparent .l-subheader .w-socials-item-link:hover,
.no-touch .l-header.transparent .l-subheader .w-search-open:hover,
.no-touch .l-header.transparent .l-subheader .w-cart-h:hover .w-cart-link,
.no-touch .l-header.transparent .l-subheader .w-cart-quantity,
.no-touch .l-header.transparent .type_desktop .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	color: <?php echo us_get_option( 'color_header_transparent_text_hover' ) ?>;
	}
.l-header.transparent .w-nav-title:after {
	background-color: <?php echo us_get_option( 'color_header_transparent_text_hover' ) ?>;
	}

/* Search Form Background Color */
.w-search.layout_simple .w-form input,
.w-search.layout_modern .w-form input,
.w-search.layout_fullwidth .w-form,
.w-search.layout_fullscreen .w-form:before {
	background-color: <?php echo us_get_option( 'color_header_search_bg' ) ?>;
	}

/* Search Form Text Color */
.w-search .w-form {
	color: <?php echo us_get_option( 'color_header_search_text' ) ?>;
	}

/*************************** MAIN MENU ***************************/

/* Menu Hover Background Color */
.no-touch .l-header .menu-item-language > a:hover,
.no-touch .type_desktop .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	background-color: <?php echo us_get_option( 'color_menu_hover_bg' ) ?>;
	}

/* Menu Hover Text Color */
.no-touch .l-header .menu-item-language > a:hover,
.no-touch .type_desktop .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_1:hover .w-nav-anchor.level_1 {
	color: <?php echo us_get_option( 'color_menu_hover_text' ) ?>;
	}
.w-nav-title:after {
	background-color: <?php echo us_get_option( 'color_menu_hover_text' ) ?>;
	}

/* Menu Active Text Color */
.l-header .w-nav-item.level_1.active .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	color: <?php echo us_get_option( 'color_menu_active_text' ) ?>;
	}

/* Menu Active Background Color */
.l-header .w-nav-item.level_1.active .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	background-color: <?php echo us_get_option( 'color_menu_active_bg' ) ?>;
	}

/* Transparent Menu Active Text Color */
.l-header.transparent .type_desktop .w-nav-item.level_1.active .w-nav-anchor.level_1,
.l-header.transparent .type_desktop .w-nav-item.level_1.current-menu-item .w-nav-anchor.level_1,
.l-header.transparent .type_desktop .w-nav-item.level_1.current-menu-ancestor .w-nav-anchor.level_1 {
	color: <?php echo us_get_option( 'color_menu_transparent_active_text' ) ?>;
	}

/* Dropdown Background Color */
.type_desktop .submenu-languages,
.l-header .w-nav-list.level_2,
.l-header .w-nav-list.level_3,
.l-header .w-nav-list.level_4 {
	background-color: <?php echo us_get_option( 'color_drop_bg' ) ?>;
	}

/* Dropdown Text Color */
.type_desktop .submenu-languages,
.l-header .w-nav-anchor.level_2,
.l-header .w-nav-anchor.level_3,
.l-header .w-nav-anchor.level_4,
.type_desktop [class*="columns"] .w-nav-item.menu-item-has-children.active .w-nav-anchor.level_2,
.type_desktop [class*="columns"] .w-nav-item.menu-item-has-children.current-menu-item .w-nav-anchor.level_2,
.type_desktop [class*="columns"] .w-nav-item.menu-item-has-children.current-menu-ancestor .w-nav-anchor.level_2,
.no-touch .type_desktop [class*="columns"] .w-nav-item.menu-item-has-children:hover .w-nav-anchor.level_2 {
	color: <?php echo us_get_option( 'color_drop_text' ) ?>;
	}

/* Dropdown Hover Background Color */
.no-touch .type_desktop .submenu-languages .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3,
.no-touch .l-header .w-nav-item.level_4:hover .w-nav-anchor.level_4 {
	background-color: <?php echo us_get_option( 'color_drop_hover_bg' ) ?>;
	}

/* Dropdown Hover Text Color */
.no-touch .type_desktop .submenu-languages .menu-item-language:hover > a,
.no-touch .l-header .w-nav-item.level_2:hover .w-nav-anchor.level_2,
.no-touch .l-header .w-nav-item.level_3:hover .w-nav-anchor.level_3,
.no-touch .l-header .w-nav-item.level_4:hover .w-nav-anchor.level_4 {
	color: <?php echo us_get_option( 'color_drop_hover_text' ) ?>;
	}

/* Dropdown Active Background Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3,
.l-header .w-nav-item.level_4.current-menu-item .w-nav-anchor.level_4,
.l-header .w-nav-item.level_4.current-menu-ancestor .w-nav-anchor.level_4 {
	background-color: <?php echo us_get_option( 'color_drop_active_bg' ) ?>;
	}

/* Dropdown Active Text Color */
.l-header .w-nav-item.level_2.current-menu-item .w-nav-anchor.level_2,
.l-header .w-nav-item.level_2.current-menu-ancestor .w-nav-anchor.level_2,
.l-header .w-nav-item.level_3.current-menu-item .w-nav-anchor.level_3,
.l-header .w-nav-item.level_3.current-menu-ancestor .w-nav-anchor.level_3,
.l-header .w-nav-item.level_4.current-menu-item .w-nav-anchor.level_4,
.l-header .w-nav-item.level_4.current-menu-ancestor .w-nav-anchor.level_4 {
	color: <?php echo us_get_option( 'color_drop_active_text' ) ?>;
	}

/* Menu Button Background Color */
.btn.w-nav-item .w-nav-anchor.level_1 {
	background-color: <?php echo us_get_option( 'color_menu_button_bg' ) ?> !important;
	}

/* Menu Button Text Color */
.btn.w-nav-item .w-nav-anchor.level_1 {
	color: <?php echo us_get_option( 'color_menu_button_text' ) ?> !important;
	}

/* Menu Button Hover Background Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:before {
	background-color: <?php echo us_get_option( 'color_menu_button_hover_bg' ) ?> !important;
	}

/* Menu Button Hover Text Color */
.no-touch .btn.w-nav-item .w-nav-anchor.level_1:hover {
	color: <?php echo us_get_option( 'color_menu_button_hover_text' ) ?> !important;
	}

/*************************** MAIN CONTENT ***************************/

/* Background Color */
.l-preloader,
.l-canvas,
.w-blog.layout_masonry .w-blog-post-h,
.w-cart-dropdown,
.g-filters.style_1 .g-filters-item.active,
.no-touch .g-filters-item.active:hover,
.w-tabs.layout_default .w-tabs-item.active,
.no-touch .w-tabs.layout_default .w-tabs-item.active:hover,
.w-tabs.layout_ver .w-tabs-item.active,
.no-touch .w-tabs.layout_ver .w-tabs-item.active:hover,
.w-tabs.layout_timeline .w-tabs-item,
.w-tabs.layout_timeline .w-tabs-section-header-h,
.no-touch #lang_sel ul ul a:hover,
.no-touch #lang_sel_click ul ul a:hover,
#lang_sel_footer,
.woocommerce-tabs .tabs li.active,
.no-touch .woocommerce-tabs .tabs li.active:hover,
.woocommerce .stars span:after,
.woocommerce .stars span a:after,
.woocommerce #payment .payment_box input[type="text"],
#bbp-user-navigation li.current,
.gform_wrapper .chosen-container-single .chosen-search input[type="text"],
.gform_wrapper .chosen-container-multi .chosen-choices li.search-choice {
	background-color: <?php echo us_get_option( 'color_content_bg' ) ?>;
	}
.woocommerce .blockUI.blockOverlay {
	background-color: <?php echo us_get_option( 'color_content_bg' ) ?> !important;
	}
a.w-btn.color_contrast,
.w-btn.color_contrast,
.no-touch a.w-btn.color_contrast:hover,
.no-touch .w-btn.color_contrast:hover,
.no-touch a.w-btn.color_contrast.style_outlined:hover,
.no-touch .w-btn.color_contrast.style_outlined:hover,
.w-iconbox.style_circle.color_contrast .w-iconbox-icon {
	color: <?php echo us_get_option( 'color_content_bg' ) ?>;
	}

/* Alternate Background Color */
input,
textarea,
select,
.l-section.for_blogpost .w-blog-post-preview,
.w-actionbox.color_light,
.w-blog-post-preview-icon,
.g-filters.style_1,
.g-filters.style_2 .g-filters-item.active,
.w-iconbox.style_circle.color_light .w-iconbox-icon,
.g-loadmore-btn,
.w-pricing-item-header,
.w-progbar-bar,
.w-progbar.style_3 .w-progbar-bar:before,
.w-progbar.style_3 .w-progbar-bar-count,
.w-tabs-list,
.w-testimonial.style_4:before,
.no-touch .l-main .widget_nav_menu a:hover,
#lang_sel a,
#lang_sel_click a,
.smile-icon-timeline-wrap .timeline-wrapper .timeline-block,
.smile-icon-timeline-wrap .timeline-feature-item.feat-item,
.woocommerce .quantity .plus,
.woocommerce .quantity .minus,
.select2-container a.select2-choice,
.select2-drop .select2-search input,
.woocommerce-tabs .tabs,
.woocommerce #payment .payment_box,
#subscription-toggle,
#favorite-toggle,
#bbp-user-navigation,
.gform_wrapper .chosen-container-single .chosen-single,
.gform_wrapper .chosen-container .chosen-drop,
.gform_wrapper .chosen-container-multi .chosen-choices {
	background-color: <?php echo us_get_option( 'color_content_bg_alt' ) ?>;
	}
.timeline-wrapper .timeline-post-right .ult-timeline-arrow l,
.timeline-wrapper .timeline-post-left .ult-timeline-arrow l,
.timeline-feature-item.feat-item .ult-timeline-arrow l,
.woocommerce #payment .payment_box:after {
	border-color: <?php echo us_get_option( 'color_content_bg_alt' ) ?>;
	}

/* Border Color */
.l-section,
.g-cols > div,
.w-blog-post,
.w-comments-list,
.w-pricing-item-h,
.w-profile,
.w-separator,
.w-sharing-item,
.w-tabs-section,
.w-tabs-section-header:before,
.w-tabs.layout_timeline .w-tabs-list:before,
.w-tabs.layout_timeline.accordion .w-tabs-section-content,
.g-tags > a,
.w-testimonial.style_1,
.widget_calendar #calendar_wrap,
.l-main .widget_nav_menu > div,
.l-main .widget_nav_menu .menu-item a,
.widget_nav_menu .menu-item.menu-item-has-children + .menu-item > a,
.select2-container a.select2-choice,
.smile-icon-timeline-wrap .timeline-line,
.woocommerce table th,
.woocommerce table td,
.woocommerce .login,
.woocommerce .checkout_coupon,
.woocommerce .register,
.woocommerce .cart.variations_form,
.woocommerce .cart .group_table,
.woocommerce .cart .group_table td,
.woocommerce .commentlist .comment-text,
.woocommerce .comment-respond,
.woocommerce .related,
.woocommerce .upsells,
.woocommerce .cross-sells,
.woocommerce .checkout #order_review,
.woocommerce ul.order_details li,
.woocommerce .shop_table.my_account_orders,
.widget_price_filter .ui-slider-handle,
.widget_layered_nav ul,
.widget_layered_nav ul li,
#bbpress-forums fieldset,
.bbp-login-form fieldset,
#bbpress-forums .bbp-body > ul,
#bbpress-forums li.bbp-header,
.bbp-replies .bbp-body,
div.bbp-forum-header,
div.bbp-topic-header,
div.bbp-reply-header,
.bbp-pagination-links a,
.bbp-pagination-links span.current,
span.bbp-topic-pagination a.page-numbers,
.bbp-logged-in,
.gform_wrapper .gsection,
.gform_wrapper .gf_page_steps,
.gform_wrapper li.gfield_creditcard_warning,
.form_saved_message {
	border-color: <?php echo us_get_option( 'color_content_border' ) ?>;
	}
.w-separator,
.w-iconbox.color_light .w-iconbox-icon,
.w-testimonial.style_3 .w-testimonial-text:after,
.w-testimonial.style_3 .w-testimonial-text:before {
	color: <?php echo us_get_option( 'color_content_border' ) ?>;
	}
a.w-btn.color_light,
.w-btn.color_light,
.w-btn.color_light.style_outlined:before,
.w-btn.w-blog-post-more:before,
.w-iconbox.style_circle.color_light .w-iconbox-icon,
.no-touch .g-loadmore-btn:hover,
.woocommerce .button,
.no-touch .woocommerce .quantity .plus:hover,
.no-touch .woocommerce .quantity .minus:hover,
.widget_price_filter .ui-slider,
.gform_wrapper .gform_page_footer .gform_previous_button {
	background-color: <?php echo us_get_option( 'color_content_border' ) ?>;
	}
a.w-btn.color_light.style_outlined,
.w-btn.color_light.style_outlined,
.w-btn.w-blog-post-more,
.w-iconbox.style_outlined.color_light .w-iconbox-icon,
.w-person-links-item,
.w-socials-item-link,
.pagination .page-numbers {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_content_border' ) ?> inset;
	}

/* Heading Color */
h1, h2, h3, h4, h5, h6,
.no-touch a.w-btn.color_light:hover,
.no-touch .w-btn.color_light:hover,
.no-touch .w-btn.w-blog-post-more:hover,
.w-counter-number,
.w-pricing-item-header,
.w-progbar.color_custom .w-progbar-title,
.woocommerce .products .product .price,
.woocommerce div.product .price,
.gform_wrapper .chosen-container-single .chosen-single {
	color: <?php echo us_get_option( 'color_content_heading' ) ?>;
	}
.w-progbar.color_contrast .w-progbar-bar-h {
	background-color: <?php echo us_get_option( 'color_content_heading' ) ?>;
	}

/* Text Color */
input,
textarea,
select,
.l-canvas,
a.w-btn.color_contrast.style_outlined,
.w-btn.color_contrast.style_outlined,
.w-btn.w-blog-post-more,
.w-cart-dropdown,
.w-form-row-field:before,
.w-iconbox.color_contrast .w-iconbox-icon,
.w-iconbox.color_light.style_circle .w-iconbox-icon,
.w-tabs.layout_timeline .w-tabs-item,
.w-tabs.layout_timeline .w-tabs-section-header-h,
.woocommerce .button {
	color: <?php echo us_get_option( 'color_content_text' ) ?>;
	}
a.w-btn.color_contrast,
.w-btn.color_contrast,
.w-btn.color_contrast.style_outlined:before,
.w-iconbox.style_circle.color_contrast .w-iconbox-icon {
	background-color: <?php echo us_get_option( 'color_content_text' ) ?>;
	}
a.w-btn.color_contrast.style_outlined,
.w-btn.color_contrast.style_outlined,
.w-iconbox.style_outlined.color_contrast .w-iconbox-icon {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_content_text' ) ?> inset;
	}

/* Primary Color */
a,
.highlight_primary,
.l-preloader,
.no-touch .l-titlebar .g-nav-item:hover,
a.w-btn.color_primary.style_outlined,
.w-btn.color_primary.style_outlined,
.l-main .w-contacts-item:before,
.w-counter.color_primary .w-counter-number,
.g-filters-item.active,
.no-touch .g-filters.style_1 .g-filters-item.active:hover,
.no-touch .g-filters.style_2 .g-filters-item.active:hover,
.w-form-row.focused .w-form-row-field:before,
.w-iconbox.color_primary .w-iconbox-icon,
.no-touch .w-iconbox-link:hover .w-iconbox-title,
.no-touch .w-logos .owl-prev:hover,
.no-touch .w-logos .owl-next:hover,
.w-separator.color_primary,
.w-sharing.type_outlined.color_primary .w-sharing-item,
.no-touch .w-sharing.type_simple.color_primary .w-sharing-item:hover .w-sharing-icon,
.w-tabs.layout_default .w-tabs-item.active,
.no-touch .w-tabs.layout_default .w-tabs-item.active:hover,
.w-tabs-section.active .w-tabs-section-header,
.w-tabs.layout_ver .w-tabs-item.active,
.no-touch .w-tabs.layout_ver .w-tabs-item.active:hover,
.no-touch .g-tags > a:hover,
.w-testimonial.style_2:before,
.woocommerce .products .product .button,
.woocommerce .star-rating span:before,
.woocommerce-tabs .tabs li.active,
.no-touch .woocommerce-tabs .tabs li.active:hover,
.woocommerce .stars span a:after,
#subscription-toggle span.is-subscribed:before,
#favorite-toggle span.is-favorite:before {
	color: <?php echo us_get_option( 'color_content_primary' ) ?>;
	}
.l-section.color_primary,
.l-titlebar.color_primary,
.no-touch .l-navigation-item:hover .l-navigation-item-arrow,
.highlight_primary_bg,
.w-actionbox.color_primary,
button,
input[type="submit"],
a.w-btn.color_primary,
.w-btn.color_primary,
.w-btn.color_primary.style_outlined:before,
.no-touch .g-filters-item:hover,
.w-iconbox.style_circle.color_primary .w-iconbox-icon,
.no-touch .w-iconbox.style_circle .w-iconbox-icon:before,
.no-touch .w-iconbox.style_outlined .w-iconbox-icon:before,
.no-touch .w-person.layout_toplinks .w-person-links,
.w-pricing-item.type_featured .w-pricing-item-header,
.w-progbar.color_primary .w-progbar-bar-h,
.w-sharing.type_solid.color_primary .w-sharing-item,
.w-sharing.type_fixed.color_primary .w-sharing-item,
.w-sharing.type_outlined.color_primary .w-sharing-item:before,
.w-tabs.layout_timeline .w-tabs-item:before,
.w-tabs.layout_timeline .w-tabs-section-header-h:before,
.no-touch .w-toplink.active:hover,
.no-touch .pagination .page-numbers:before,
.pagination .page-numbers.current,
.l-main .widget_nav_menu .menu-item.current-menu-item > a,
.rsDefault .rsThumb.rsNavSelected,
.no-touch .tp-leftarrow.tparrows.custom:before,
.no-touch .tp-rightarrow.tparrows.custom:before,
.smile-icon-timeline-wrap .timeline-separator-text .sep-text,
.smile-icon-timeline-wrap .timeline-wrapper .timeline-dot,
.smile-icon-timeline-wrap .timeline-feature-item .timeline-dot,
p.demo_store,
.woocommerce .button.alt,
.woocommerce .button.checkout,
.no-touch .woocommerce .products .product .button:hover,
.woocommerce .products .product .button.loading,
.woocommerce .onsale,
.widget_price_filter .ui-slider-range,
.widget_layered_nav ul li.chosen,
.widget_layered_nav_filters ul li a,
.no-touch .bbp-pagination-links a:hover,
.bbp-pagination-links span.current,
.no-touch span.bbp-topic-pagination a.page-numbers:hover,
.gform_wrapper .gform_page_footer .gform_next_button,
.gform_wrapper .gf_progressbar_percentage,
.gform_wrapper .chosen-container .chosen-results li.highlighted {
	background-color: <?php echo us_get_option( 'color_content_primary' ) ?>;
	}
.g-html blockquote,
.no-touch .l-titlebar .g-nav-item:hover,
.g-filters.style_3 .g-filters-item.active,
.no-touch .w-logos .owl-prev:hover,
.no-touch .w-logos .owl-next:hover,
.no-touch .w-logos.style_1 .w-logos-item:hover,
.w-separator.color_primary,
.w-tabs.layout_default .w-tabs-item.active,
.no-touch .w-tabs.layout_default .w-tabs-item.active:hover,
.w-tabs.layout_ver .w-tabs-item.active,
.no-touch .w-tabs.layout_ver .w-tabs-item.active:hover,
.no-touch .g-tags > a:hover,
.no-touch .w-testimonial.style_1:hover,
.l-main .widget_nav_menu .menu-item.current-menu-item > a,
.woocommerce-tabs .tabs li.active,
.no-touch .woocommerce-tabs .tabs li.active:hover,
.widget_layered_nav ul li.chosen,
.bbp-pagination-links span.current,
.no-touch #bbpress-forums .bbp-pagination-links a:hover,
.no-touch #bbpress-forums .bbp-topic-pagination a:hover,
#bbp-user-navigation li.current {
	border-color: <?php echo us_get_option( 'color_content_primary' ) ?>;
	}
a.w-btn.color_primary.style_outlined,
.w-btn.color_primary.style_outlined,
.l-main .w-contacts-item:before,
.w-iconbox.color_primary.style_outlined .w-iconbox-icon,
.w-sharing.type_outlined.color_primary .w-sharing-item,
.w-tabs.layout_timeline .w-tabs-item,
.w-tabs.layout_timeline .w-tabs-section-header-h,
.woocommerce .products .product .button {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_content_primary' ) ?> inset;
	}
input:focus,
textarea:focus,
select:focus {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_content_primary' ) ?>;
	}

/* Secondary Color */
.no-touch a:hover,
.highlight_secondary,
.no-touch .w-blog-post-link:hover .w-blog-post-title,
.no-touch .w-blog-post-link:hover .w-blog-post-preview-icon,
.no-touch .w-blog-post-meta a:hover,
.no-touch .w-blognav-prev:hover .w-blognav-title,
.no-touch .w-blognav-next:hover .w-blognav-title,
a.w-btn.color_secondary.style_outlined,
.w-btn.color_secondary.style_outlined,
.w-counter.color_secondary .w-counter-number,
.w-iconbox.color_secondary .w-iconbox-icon,
.w-separator.color_secondary,
.w-sharing.type_outlined.color_secondary .w-sharing-item,
.no-touch .w-sharing.type_simple.color_secondary .w-sharing-item:hover .w-sharing-icon,
.no-touch .l-main .widget_tag_cloud a:hover,
.no-touch .l-main .widget_product_tag_cloud .tagcloud a:hover,
.no-touch .bbp_widget_login a.button.logout-link:hover {
	color: <?php echo us_get_option( 'color_content_secondary' ) ?>;
	}
.l-section.color_secondary,
.l-titlebar.color_secondary,
.highlight_secondary_bg,
.no-touch input[type="submit"]:hover,
a.w-btn.color_secondary,
.w-btn.color_secondary,
.w-btn.color_secondary.style_outlined:before,
.w-actionbox.color_secondary,
.w-iconbox.style_circle.color_secondary .w-iconbox-icon,
.w-progbar.color_secondary .w-progbar-bar-h,
.w-sharing.type_solid.color_secondary .w-sharing-item,
.w-sharing.type_fixed.color_secondary .w-sharing-item,
.w-sharing.type_outlined.color_secondary .w-sharing-item:before,
.no-touch .woocommerce .button:hover,
.no-touch .woocommerce input[type="submit"]:hover,
.no-touch .woocommerce .button.alt:hover,
.no-touch .woocommerce .button.checkout:hover,
.no-touch .woocommerce .product-remove a.remove:hover,
.no-touch .widget_layered_nav_filters ul li a:hover {
	background-color: <?php echo us_get_option( 'color_content_secondary' ) ?>;
	}
.w-separator.color_secondary {
	border-color: <?php echo us_get_option( 'color_content_secondary' ) ?>;
	}
a.w-btn.color_secondary.style_outlined,
.w-btn.color_secondary.style_outlined,
.w-iconbox.color_secondary.style_outlined .w-iconbox-icon,
.w-sharing.type_outlined.color_secondary .w-sharing-item {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_content_secondary' ) ?> inset;
	}

/* Fade Elements Color */
.highlight_faded,
.w-blog-post-preview-icon,
.w-blog-post-meta,
.w-profile-link.for_logout,
.w-testimonial-person-meta,
.w-testimonial.style_4:before,
.l-main .widget_tag_cloud a,
.l-main .widget_product_tag_cloud .tagcloud a,
.woocommerce-breadcrumb,
.woocommerce .star-rating:before,
.woocommerce .stars span:after,
.woocommerce .product-remove a.remove,
p.bbp-topic-meta,
.bbp_widget_login a.button.logout-link {
	color: <?php echo us_get_option( 'color_content_faded' ) ?>;
	}
.w-blog.layout_latest .w-blog-post-meta-date {
	border-color: <?php echo us_get_option( 'color_content_faded' ) ?>;
	}

/*************************** ALTERNATE CONTENT ***************************/

/* Background Color */
.l-section.color_alternate,
.l-titlebar.color_alternate,
.color_alternate .g-filters.style_1 .g-filters-item.active,
.no-touch .color_alternate .g-filters-item.active:hover,
.color_alternate .w-tabs.layout_default .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_default .w-tabs-item.active:hover,
.color_alternate .w-tabs.layout_ver .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_ver .w-tabs-item.active:hover,
.color_alternate .w-tabs.layout_timeline .w-tabs-item,
.color_alternate .w-tabs.layout_timeline .w-tabs-section-header-h {
	background-color: <?php echo us_get_option( 'color_alt_content_bg' ) ?>;
	}
.color_alternate a.w-btn.color_contrast,
.color_alternate .w-btn.color_contrast,
.no-touch .color_alternate a.w-btn.color_contrast:hover,
.no-touch .color_alternate .w-btn.color_contrast:hover,
.no-touch .color_alternate a.w-btn.color_contrast.style_outlined:hover,
.no-touch .color_alternate .w-btn.color_contrast.style_outlined:hover,
.color_alternate .w-iconbox.style_circle.color_contrast .w-iconbox-icon {
	color: <?php echo us_get_option( 'color_alt_content_bg' ) ?>;
	}

/* Alternate Background Color */
.color_alternate input,
.color_alternate textarea,
.color_alternate select,
.color_alternate .w-blog-post-preview-icon,
.color_alternate .g-filters.style_1,
.color_alternate .g-filters.style_2 .g-filters-item.active,
.color_alternate .w-iconbox.style_circle.color_light .w-iconbox-icon,
.color_alternate .g-loadmore-btn,
.color_alternate .w-pricing-item-header,
.color_alternate .w-progbar-bar,
.color_alternate .w-tabs-list,
.color_alternate .w-testimonial.style_4:before {
	background-color: <?php echo us_get_option( 'color_alt_content_bg_alt' ) ?>;
	}

/* Border Color */
.l-section.color_alternate,
.color_alternate .g-cols > div,
.color_alternate .w-blog-post,
.color_alternate .w-comments-list,
.color_alternate .w-pricing-item-h,
.color_alternate .w-profile,
.color_alternate .w-separator,
.color_alternate .w-tabs-section,
.color_alternate .w-tabs-section-header:before,
.color_alternate .w-tabs.layout_timeline .w-tabs-list:before,
.color_alternate .w-tabs.layout_timeline.accordion .w-tabs-section-content,
.color_alternate .w-testimonial.style_1 {
	border-color: <?php echo us_get_option( 'color_alt_content_border' ) ?>;
	}
.color_alternate .w-separator,
.color_alternate .w-iconbox.color_light .w-iconbox-icon,
.color_alternate .w-testimonial.style_3 .w-testimonial-text:after,
.color_alternate .w-testimonial.style_3 .w-testimonial-text:before {
	color: <?php echo us_get_option( 'color_alt_content_border' ) ?>;
	}
.color_alternate a.w-btn.color_light,
.color_alternate .w-btn.color_light,
.color_alternate .w-btn.color_light.style_outlined:before,
.color_alternate .w-btn.w-blog-post-more:before,
.color_alternate .w-iconbox.style_circle.color_light .w-iconbox-icon,
.no-touch .color_alternate .g-loadmore-btn:hover {
	background-color: <?php echo us_get_option( 'color_alt_content_border' ) ?>;
	}
.color_alternate a.w-btn.color_light.style_outlined,
.color_alternate .w-btn.color_light.style_outlined,
.color_alternate .w-btn.w-blog-post-more,
.color_alternate .w-iconbox.style_outlined.color_light .w-iconbox-icon,
.color_alternate .w-person-links-item,
.color_alternate .w-socials-item-link,
.color_alternate .pagination .page-numbers {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_alt_content_border' ) ?> inset;
	}

/* Heading Color */
.color_alternate h1,
.color_alternate h2,
.color_alternate h3,
.color_alternate h4,
.color_alternate h5,
.color_alternate h6,
.no-touch .color_alternate a.w-btn.color_light:hover,
.no-touch .color_alternate .w-btn.color_light:hover,
.no-touch .color_alternate .w-btn.w-blog-post-more:hover,
.color_alternate .w-counter-number,
.color_alternate .w-pricing-item-header {
	color: <?php echo us_get_option( 'color_alt_content_heading' ) ?>;
	}
.color_alternate .w-progbar.color_contrast .w-progbar-bar-h {
	background-color: <?php echo us_get_option( 'color_alt_content_heading' ) ?>;
	}

/* Text Color */
.l-titlebar.color_alternate,
.l-section.color_alternate,
.color_alternate input,
.color_alternate textarea,
.color_alternate select,
.color_alternate a.w-btn.color_contrast.style_outlined,
.color_alternate .w-btn.color_contrast.style_outlined,
.color_alternate .w-btn.w-blog-post-more,
.color_alternate .w-form-row-field:before,
.color_alternate .w-iconbox.color_contrast .w-iconbox-icon,
.color_alternate .w-iconbox.color_light.style_circle .w-iconbox-icon,
.color_alternate .w-tabs.layout_timeline .w-tabs-item,
.color_alternate .w-tabs.layout_timeline .w-tabs-section-header-h {
	color: <?php echo us_get_option( 'color_alt_content_text' ) ?>;
	}
.color_alternate a.w-btn.color_contrast,
.color_alternate .w-btn.color_contrast,
.color_alternate .w-btn.color_contrast.style_outlined:before,
.color_alternate .w-iconbox.style_circle.color_contrast .w-iconbox-icon {
	background-color: <?php echo us_get_option( 'color_alt_content_text' ) ?>;
	}
.color_alternate a.w-btn.color_contrast.style_outlined,
.color_alternate .w-btn.color_contrast.style_outlined,
.color_alternate .w-iconbox.style_outlined.color_contrast .w-iconbox-icon {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_alt_content_text' ) ?> inset;
	}

/* Primary Color */
.color_alternate a,
.color_alternate .highlight_primary,
.no-touch .l-titlebar.color_alternate .g-nav-item:hover,
.color_alternate a.w-btn.color_primary.style_outlined,
.color_alternate .w-btn.color_primary.style_outlined,
.l-main .color_alternate .w-contacts-item:before,
.color_alternate .w-counter.color_primary .w-counter-number,
.color_alternate .g-filters-item.active,
.no-touch .color_alternate .g-filters-item.active:hover,
.color_alternate .w-form-row.focused .w-form-row-field:before,
.color_alternate .w-iconbox.color_primary .w-iconbox-icon,
.no-touch .color_alternate .w-iconbox-link:hover .w-iconbox-title,
.no-touch .color_alternate .w-logos .owl-prev:hover,
.no-touch .color_alternate .w-logos .owl-next:hover,
.color_alternate .w-separator.color_primary,
.color_alternate .w-tabs.layout_default .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_default .w-tabs-item.active:hover,
.color_alternate .w-tabs-section.active .w-tabs-section-header,
.color_alternate .w-tabs.layout_ver .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_ver .w-tabs-item.active:hover,
.color_alternate .w-testimonial.style_2:before {
	color: <?php echo us_get_option( 'color_alt_content_primary' ) ?>;
	}
.color_alternate .highlight_primary_bg,
.color_alternate .w-actionbox.color_primary,
.color_alternate button,
.color_alternate input[type="submit"],
.color_alternate a.w-btn.color_primary,
.color_alternate .w-btn.color_primary,
.color_alternate .w-btn.color_primary.style_outlined:before,
.no-touch .color_alternate .g-filters-item:hover,
.color_alternate .w-iconbox.style_circle.color_primary .w-iconbox-icon,
.no-touch .color_alternate .w-iconbox.style_circle .w-iconbox-icon:before,
.no-touch .color_alternate .w-iconbox.style_outlined .w-iconbox-icon:before,
.no-touch .color_alternate .w-person.layout_toplinks .w-person-links,
.color_alternate .w-pricing-item.type_featured .w-pricing-item-header,
.color_alternate .w-progbar.color_primary .w-progbar-bar-h,
.color_alternate .w-tabs.layout_timeline .w-tabs-item:before,
.color_alternate .w-tabs.layout_timeline .w-tabs-section-header-h:before,
.no-touch .color_alternate .w-toplink.active:hover,
.no-touch .color_alternate .pagination .page-numbers:before,
.color_alternate .pagination .page-numbers.current {
	background-color: <?php echo us_get_option( 'color_alt_content_primary' ) ?>;
	}
.g-html .color_alternate blockquote,
.no-touch .l-titlebar.color_alternate .g-nav-item:hover,
.color_alternate .g-filters.style_3 .g-filters-item.active,
.no-touch .color_alternate .w-logos .owl-prev:hover,
.no-touch .color_alternate .w-logos .owl-next:hover,
.no-touch .color_alternate .w-logos.style_1 .w-logos-item:hover,
.color_alternate .w-separator.color_primary,
.color_alternate .w-tabs.layout_default .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_default .w-tabs-item.active:hover,
.color_alternate .w-tabs.layout_ver .w-tabs-item.active,
.no-touch .color_alternate .w-tabs.layout_ver .w-tabs-item.active:hover,
.no-touch .color_alternate .g-tags > a:hover,
.no-touch .color_alternate .w-testimonial.style_1:hover {
	border-color: <?php echo us_get_option( 'color_alt_content_primary' ) ?>;
	}
.color_alternate a.w-btn.color_primary.style_outlined,
.color_alternate .w-btn.color_primary.style_outlined,
.l-main .color_alternate .w-contacts-item:before,
.color_alternate .w-iconbox.color_primary.style_outlined .w-iconbox-icon,
.color_alternate .w-tabs.layout_timeline .w-tabs-item,
.color_alternate .w-tabs.layout_timeline .w-tabs-section-header-h {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_alt_content_primary' ) ?> inset;
	}
.color_alternate input:focus,
.color_alternate textarea:focus,
.color_alternate select:focus {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_alt_content_primary' ) ?>;
	}

/* Secondary Color */
.no-touch .color_alternate a:hover,
.color_alternate .highlight_secondary,
.no-touch .color_alternate .w-blog-post-link:hover .w-blog-post-title,
.no-touch .color_alternate .w-blog-post-link:hover .w-blog-post-preview-icon,
.no-touch .color_alternate .w-blog-post-meta a:hover,
.color_alternate a.w-btn.color_secondary.style_outlined,
.color_alternate .w-btn.color_secondary.style_outlined,
.color_alternate .w-counter.color_secondary .w-counter-number,
.color_alternate .w-iconbox.color_secondary .w-iconbox-icon,
.color_alternate .w-separator.color_secondary {
	color: <?php echo us_get_option( 'color_alt_content_secondary' ) ?>;
	}
.color_alternate .highlight_secondary_bg,
.no-touch .color_alternate input[type="submit"]:hover,
.color_alternate a.w-btn.color_secondary,
.color_alternate .w-btn.color_secondary,
.color_alternate .w-btn.color_secondary.style_outlined:before,
.color_alternate .w-actionbox.color_secondary,
.color_alternate .w-iconbox.style_circle.color_secondary .w-iconbox-icon,
.color_alternate .w-progbar.color_secondary .w-progbar-bar-h {
	background-color: <?php echo us_get_option( 'color_alt_content_secondary' ) ?>;
	}
.color_alternate .w-separator.color_secondary {
	border-color: <?php echo us_get_option( 'color_alt_content_secondary' ) ?>;
	}
.color_alternate a.w-btn.color_secondary.style_outlined,
.color_alternate .w-btn.color_secondary.style_outlined,
.color_alternate .w-iconbox.color_secondary.style_outlined .w-iconbox-icon {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_alt_content_secondary' ) ?> inset;
	}

/* Fade Elements Color */
.color_alternate .highlight_faded,
.color_alternate .w-blog-post-preview-icon,
.color_alternate .w-blog-post-meta,
.color_alternate .w-profile-link.for_logout,
.color_alternate .w-testimonial-person-meta,
.color_alternate .w-testimonial.style_4:before {
	color: <?php echo us_get_option( 'color_alt_content_faded' ) ?>;
	}
.color_alternate .w-blog.layout_latest .w-blog-post-meta-date {
	border-color: <?php echo us_get_option( 'color_alt_content_faded' ) ?>;
	}

/*************************** SUBFOOTER ***************************/

/* Background Color */
.l-subfooter.at_top,
.no-touch .l-subfooter.at_top #lang_sel ul ul a:hover,
.no-touch .l-subfooter.at_top #lang_sel_click ul ul a:hover {
	background-color: <?php echo us_get_option( 'color_subfooter_bg' ) ?>;
	}

/* Alternate Background Color */
.l-subfooter.at_top input,
.l-subfooter.at_top textarea,
.l-subfooter.at_top select,
.no-touch .l-subfooter.at_top #lang_sel a,
.no-touch .l-subfooter.at_top #lang_sel_click a {
	background-color: <?php echo us_get_option( 'color_subfooter_bg_alt' ) ?>;
	}

/* Border Color */
.l-subfooter.at_top,
.l-subfooter.at_top .w-profile,
.l-subfooter.at_top .widget_calendar #calendar_wrap {
	border-color: <?php echo us_get_option( 'color_subfooter_border' ) ?>;
	}
.l-subfooter.at_top .w-socials-item-link {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_subfooter_border' ) ?> inset;
	}

/* Heading Color */
.l-subfooter.at_top h1,
.l-subfooter.at_top h2,
.l-subfooter.at_top h3,
.l-subfooter.at_top h4,
.l-subfooter.at_top h5,
.l-subfooter.at_top h6,
.l-subfooter.at_top input,
.l-subfooter.at_top textarea,
.l-subfooter.at_top select,
.l-subfooter.at_top .w-form-row-field:before {
	color: <?php echo us_get_option( 'color_subfooter_heading' ) ?>;
	}

/* Text Color */
.l-subfooter.at_top {
	color: <?php echo us_get_option( 'color_subfooter_text' ) ?>;
	}

/* Link Color */
.l-subfooter.at_top a,
.l-subfooter.at_top .widget_tag_cloud .tagcloud a,
.l-subfooter.at_top .widget_product_tag_cloud .tagcloud a {
	color: <?php echo us_get_option( 'color_subfooter_link' ) ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_top a:hover,
.no-touch .l-subfooter.at_top .w-form-row.focused .w-form-row-field:before,
.no-touch .l-subfooter.at_top .widget_tag_cloud .tagcloud a:hover,
.no-touch .l-subfooter.at_top .widget_product_tag_cloud .tagcloud a:hover {
	color: <?php echo us_get_option( 'color_subfooter_link_hover' ) ?>;
	}
.l-subfooter.at_top input:focus,
.l-subfooter.at_top textarea:focus,
.l-subfooter.at_top select:focus {
	box-shadow: 0 0 0 2px <?php echo us_get_option( 'color_subfooter_link_hover' ) ?>;
	}

/*************************** FOOTER ***************************/

/* Background Color */
.l-subfooter.at_bottom {
	background-color: <?php echo us_get_option( 'color_footer_bg' ) ?>;
	}

/* Text Color */
.l-subfooter.at_bottom {
	color: <?php echo us_get_option( 'color_footer_text' ) ?>;
	}

/* Link Color */
.l-subfooter.at_bottom a {
	color: <?php echo us_get_option( 'color_footer_link' ) ?>;
	}

/* Link Hover Color */
.no-touch .l-subfooter.at_bottom a:hover {
	color: <?php echo us_get_option( 'color_footer_link_hover' ) ?>;
	}

<?php echo us_get_option( 'custom_css', '' ) ?>

<?php if ( FALSE ): ?>/* Setting IDE context */</style><?php endif; ?>
