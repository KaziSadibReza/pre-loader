<?php
/**
 * Plugin Name: Preloader
 * Description: Add preloader animation.
 * Version: 1.0
 * Author: Kazi Sadib Reza
 * Author URI: https://github.com/KaziSadibReza
 * Plugin URI: https://github.com/KaziSadibReza/pre-loader
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit('Direct access denied.');
}

/**
 * Enqueue Styles and Scripts properly
 *
 * @return void
 */
function custom_preloader_enqueue_scripts() {
    // Register and enqueue inline styles
    wp_register_style('custom-preloader-style', false);
    wp_enqueue_style('custom-preloader-style');
    
    $custom_css = "
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
        background-color: #000000; /* color of the pre loader */
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
        clip-path: polygon(0% 50%, 0 100%, 101% 100%, 0 0);
        transform-origin: bottom left;
      }

      /* The animations */
      .loaded .preloader-top {
        transform: translateX(100%) translateY(-100%);
      }

      .loaded .preloader-bottom {
        transform: translateX(-100%) translateY(100%);
      }";
    
    wp_add_inline_style('custom-preloader-style', $custom_css);
    
    /**
     * Enqueue the script with a unique handle and add inline script
     * 
     * @return void
     */
    wp_register_script('custom-preloader-script', '', [], '', true);
    wp_enqueue_script('custom-preloader-script');
    
    $custom_js = "
    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.body.classList.add('loaded');
                setTimeout(function() {
                    var preloader = document.querySelector('.preloader');
                    if (preloader) {
                        preloader.style.display = 'none';
                    }
                }, 1200);
            }, 500);
        });
    });";
    
    wp_add_inline_script('custom-preloader-script', $custom_js);
}
add_action('wp_enqueue_scripts', 'custom_preloader_enqueue_scripts');

/**
 * Add preloader HTML to the footer
 *
 * @return void
 */
function custom_preloader_add_html() {
    echo '<div class="preloader">
            <div class="preloader-half preloader-top"></div>
            <div class="preloader-half preloader-bottom"></div>
          </div>';
}
add_action('wp_footer', 'custom_preloader_add_html', 0);