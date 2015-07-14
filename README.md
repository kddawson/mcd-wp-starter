mcd wp-starter WordPress theme
===

* A just-right amount of lean, well-commented, modern, HTML5 templates based on _s: https://github.com/Automattic/_s
* A helpful 404 template.
* A bunch of potentially-useful functions in the `/inc` folder.
* Optionally configure and include Twitter Bootstrap from `inc/bootstrap/` - don't forget to add the navbar code snippet in `wp-bootstrap.php` to `header.php`.
* Custom user comments (if not using Disqus etc).
* Function to include Google Fonts.
* Function to include Masonry (from WordPress Core).
* A recommended plugins plugin ;) - saves hunting for your go-to plugins.
* A sample custom header implementation in `inc/custom-header.php` that can be activated by uncommenting one line in `functions.php` and adding the code snippet found in the comments of `inc/custom-header.php` to your `header.php` template.
* Custom template tags in `inc/template-tags.php` that keep your templates clean and neat and prevent code duplication.

LESS/SCSS
---------------
* Uses LESS CSS, but easy enough to change to SCSS.

Grunt/Gulp
---------------
* Grunt/Gulp enabled - choose your weapon and check the configuration.

Bower
---------------
* Twitter Bootstrap is an obvious out-of-the-starter-theme choice here for a Bower install but you'll be wanting the raw LESS/SCSS and JS files so you can build only what you need. To that end, copy out bootstrap.less and variables.less to your theme folder so `$bower update` doesn't override your customisations.
* This starter theme uses https://github.com/jozefizso/bower-bootstrap-less.
* or just link to the CDN files, override styles where required and have done with it.

Namespacing
---------------
1. Search for `'mcd'` (inside single quotations) to capture the text domain.
2. Search for `mcd_` to capture all the function names.
3. Search for `Text Domain: mcd` in style.css.
5. Search for `mcd-` to capture prefixed handles.
6. Search for `support@example.com` to capture support email links.
7. Search for `http://example.com/` to capture developer / company links.

OR

* Search for: `'mcd'` and replace with: `'megatherium'`.
* Search for: `mcd_` and replace with: `megatherium_`.
* Search for: `Text Domain: mcd` and replace with: `Text Domain: megatherium` in style.css.
* Search for: `mcd-` and replace with: `megatherium-`.
* Search for `support@example.com` and replace with your support email address.
* Search for `http://example.com/` and replace with relevant links.

OR

* Just leave it...

Then, update the stylesheet header in `style.css` and the links in `footer.php` with your own information. Next, update or delete this readme.
