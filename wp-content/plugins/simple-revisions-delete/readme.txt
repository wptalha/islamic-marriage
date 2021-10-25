=== Simple Revisions Delete ===
Contributors: briKou
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7Z6YVM63739Y8
Tags: admin, plugin, blog, developper, metabox, ajax, WordPress, UX, ui, jquery, revision, revisions, database, purge, cleanup, clean, tools, best, post, edition, editing, delete, remove, bulk, bulk-action, nojs, CPT, custom post types, post type
Requires at least: 3.5
Tested up to: 4.6.1
Stable tag: 1.4.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Simple Revisions Delete adds a discreet link within a post submit box to let you purge (delete) its revisions via AJAX. Bulk actions also available.


== Description ==

= What does it do? =
It helps you keep a clean database by removing unnecessary posts revisions. Unlike other similar plugins, it lets you delete only specific posts revisions, not all your site revisions at once.
The plugin is perfectly integrated in the WordPress back-end, and uses native core functions to safely delete revisions.
It is very lightweight, very simple to use, and just does the job!

= How does it work? =

The plugin adds a discreet link in the post submit box, next to the default revisions counter (see screenshots section).
When you click on it, it will purge the appropriate post revisions via AJAX (no JS is also support).
It also add a new bulk action option in the post/page row view to let you purge revisions of multiple posts at once.

Since v1.3 you can delete a single revision at once (see screenshots).

[See plugin page](http://b-website.com/simple-revisions-delete-free-wordpress-plugin "Plugin page")

NOTE: There is no admin page for this plugin - none is needed.


= Post Types support =
The default supported post types are **post** and **page**, but you can easily add custom post types or remove default post types with the following hook:
`
function bweb_wpsrd_add_post_types( $postTypes ){
	$postTypes[] = 'additional-cpt';
	$postTypes[] = 'another-cpt';
	return $postTypes;
}
add_filter( 'wpsrd_post_types_list', 'bweb_wpsrd_add_post_types' );
`
See CODEX to add support to all CPTs: https://codex.wordpress.org/Function_Reference/get_post_types

= Custom user capability =
The default capability to purge or remove rivisions is delete_post, but you can override this with the following hook:
`
function bweb_wpsrd_capability() {
	return 'edit_post';
}
add_filter('wpsrd_capability', 'bweb_wpsrd_capability');
` 
 
= Languages =
The plugin only bears a few sentences, but you can easily translate them through .MO & .PO files. Currently available languages are:

* English
* French
* Deutsch - Thanks to [mallard66](https://profiles.wordpress.org/mallard66 "mallard66")
* Dutch - Thanks to [jondor](https://profiles.wordpress.org/jondor "jondor")

Become a translator and send me your translation! [Contact-me](http://b-website.com/contact "Contact")

[CHECK OUT MY OTHER PLUGINS](http://b-website.com/category/plugins-en "More plugins by b*web")


**Please ask for help or report bugs if anything goes wrong. It is the best way to make the community benefit!**


== Installation ==

1. Upload and activate the plugin (or install it through the WP admin console)
2. That's it, it is ready to use!


== Frequently Asked Questions ==

= Who can purge my posts revisions? =
Only users who can delete a post can purge its revisions.

= Does it work with multisite? =
Yes.

= Does it work if javascript is not activated? =
Yes, but only when editing a post, not with the bulk action.


== Screenshots ==

1. The link location
2. Processing...
3. Done!
4. Bulk action
5. Single revision delete

== Changelog ==

= 1.4.7 - 11/29/2016 =
* Bug fix : fix an issue with WooCommerce duplicate product

= 1.4.6 - 11/03/2016 =
* Change text-domain to take advantage of language packs translate.wordpress.org

= 1.4.5 =
* Better respect WordPress Coding standards
* readme.txt update

= 1.4.4 =
* Tested on WP 4.3 with success!

= 1.4.3 =
* Dutch translation by [jondor](https://profiles.wordpress.org/jondor "jondor")

= 1.4.2 =
* Fix a bug when clicking on the revision link in the revision's metabox
* Change button on single revision delete by a more discreet link
* Tested on WP 4.2 with success!
* readme.txt update

= 1.4.1 =
* Fix a bug when W3 Total Cache is activated and plugins updates are available
* Fix a bug where delete button appears in the admin bottom
* Minor JS improvement
* Loader added during single revision deletion
* Change the default primary button (blue) to normal button (grey) for UX purpose

= 1.4 =
* Adding conditionnal extra notice on bulk delete
* Deutsch translation by [mallard66](https://profiles.wordpress.org/mallard66 "mallard66")

= 1.3.3 =
* Fixe Transients filtering issue

= 1.3.2 =
* PHP notices fix

= 1.3.1 =
* New screenshot added
* Readme.txt update

= 1.3 =
* Minor PHP fixes
* JS improvements
* Works with W3 Total Cache object caching
* New feature: revisions can be deleted individually
* User capability support with the new **wpsrd_capability** hook
* Readme.txt update

= 1.2.1 =
* URL parameter added on bulk action 
* Readme.txt update for W3 Total Cache issue

= 1.2 =
* NEW FEATURE: Bulk revisions delete 
* Plugin file refactoring
* Custom post type's support with the new **wpsrd_post_types_list** hook
* Readme.txt update

= 1.1.1 =
* Hide revisions metabox on revisions purge success.

= 1.1 =
* Better security.
* Check if revisions are activated on plugin activation
* No JS is now supported
* Remove inline CSS
* Readme.txt update
* Special thanks to [Julio Potier](https://profiles.wordpress.org/juliobox "Julio Potier") for his help in improving the plugin :)

= 1.0 =
* First release.


== Upgrade Notice ==

= 1.0 =
* First release.