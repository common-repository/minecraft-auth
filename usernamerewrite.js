/*global document: false */
/*global $, jQuery */
jQuery(document).ready(function ($) {
    'use strict';
    $('label').each(
        function () {
            $(this).html($(this).html().replace('Username', 'Minecraft Username'));
        }
    );
    $('.message').each(
        function () {
            $(this).html($(this).html().replace('username', 'Minecraft username'));
        }
    );
});