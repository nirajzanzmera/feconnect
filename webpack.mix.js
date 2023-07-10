const mix = require('laravel-mix');

// /*
//  |--------------------------------------------------------------------------
//  | Mix Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Mix provides a clean, fluent API for defining some Webpack build steps
//  | for your Laravel applications. By default, we are compiling the CSS
//  | file for the application as well as bundling up all the JS files.
//  |
//  */

mix.js('resources/js/app.js', 'public/js','public/stuff').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);


mix.js('resources/assets/js/emails.js', 'public/stuff/emails.js');

mix.js('resources/assets/js/lock.js', 'public/stuff/lock.js');
mix.js('resources/assets/js/hosting.js', 'public/stuff/hosting.js');
mix.js('resources/assets/js/nameservers.js', 'public/stuff/nameservers.js');
mix.js('resources/assets/js/images.js', 'public/stuff/images.js');
mix.js('resources/assets/js/standalone.js', 'public/stuff/standalone.js');
mix.js('resources/assets/js/post_page.js', 'public/stuff/post_page.js');
mix.js('resources/assets/js/page_edit.js', 'public/stuff/page_edit.js');
mix.js('resources/assets/js/notifications.js', 'public/stuff/notifications.js');
mix.js('resources/assets/js/checkout.js', 'public/stuff/checkout.js');
mix.js('resources/assets/js/datatable.js', 'public/stuff/datatable.js');
mix.js('resources/assets/js/notification_inbox.js', 'public/stuff/notification_inbox.js');

mix.js('resources/assets/js/home_page.js', 'public/stuff/home_page.js');

if (mix.inProduction()) {
    mix.version();
}
