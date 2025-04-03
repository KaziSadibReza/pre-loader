<?php
/**
 * Plugin Name: Preloader
 * Description: Add preloader animation .
 * Version: 1.0
 * Author: Kazi Sadib Reza
 * Author URI: https://github.com/KaziSadibReza
 * Plugin URI: https://github.com/KaziSadibReza/pre-loader
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Enqueue Inline Styles and Scripts
function custom_preloader_inline_scripts() {
    ?>
<style>
/* Preloader Styles */
.preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    overflow: hidden;
}

.preloader-half {
    position: absolute;
    width: 100%;
    height: 100%;
    background-color: #ff5722;
    /* Orange color */
    transition: transform 1.2s cubic-bezier(0.77, 0, 0.175, 1);
}

.preloader-top {
    top: 0;
    right: 0;
    clip-path: polygon(0 0, 100% 0, 100% 100%, 50% 50%);
    transform-origin: top right;
}

.preloader-bottom {
    bottom: 0;
    left: 0;
    clip-path: polygon(0% 50%, 0 100%, 100% 100%, 0 0);
    transform-origin: bottom left;
}

/* Animations */
.loaded .preloader-top {
    transform: translateX(100%) translateY(-100%);
}

.loaded .preloader-bottom {
    transform: translateX(-100%) translateY(100%);
}

.loaded .preloader {
    opacity: 0;
    pointer-events: none;
}
</style>
<script>
document.addEventListener("DOMContentLoaded", function() {
    window.addEventListener("load", function() {
        setTimeout(function() {
            document.body.classList.add("loaded");
            setTimeout(function() {
                document.querySelector(".preloader").style.display = "none";
            }, 1200);
        }, 1000);
    });
});
</script>
<?php
}
add_action('wp_head', 'custom_preloader_inline_scripts');

// Add Preloader HTML to the body
function custom_preloader_add_html() {
    echo '<div class="preloader">
            <div class="preloader-half preloader-top"></div>
            <div class="preloader-half preloader-bottom"></div>
          </div>';
}
add_action('wp_body_open', 'custom_preloader_add_html');