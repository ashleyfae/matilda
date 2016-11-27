/**
 * Theme Scripts
 *
 * @package   matilda
 * @copyright Copyright (c) 2016, Ashley Gibson
 * @license   GPL2+
 */

(function ($) {

    /**
     * Show/hide menu when clicking on button.
     */
    $('.menu-toggle').click(function (e) {
        e.preventDefault();

        // Menu is currently hidden, let's reveal it.
        if ($(this).attr('aria-expanded') == 'false') {

            $(this).attr('aria-expanded', 'true');
            $(this).parent().parent().addClass('toggled');


        } else {

            // Menu is open, let's close it.
            $(this).attr('aria-expanded', 'false');
            $(this).parent().parent().removeClass('toggled');

        }
    });

    /**
     * Show/hide sidebar when clicking on button.
     */
    $('.sidebar-toggle').click(function (e) {
        e.preventDefault();

        // Menu is currently hidden, let's reveal it.
        if ($(this).attr('aria-expanded') == 'false') {

            $(this).attr('aria-expanded', 'true');
            $(this).next().addClass('toggled');


        } else {

            // Menu is open, let's close it.
            $(this).attr('aria-expanded', 'false');
            $(this).next().removeClass('toggled');

        }
    });

})(jQuery);