<?php
/**
 * The template for displaying the header
 *
 * This is the template that displays all of the <head> section, opens the <body> tag and adds the site's header.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$viewport_content = apply_filters( 'hello_elementor_viewport_content', 'width=device-width, initial-scale=1' );
$enable_skip_link = apply_filters( 'hello_elementor_enable_skip_link', true );
$skip_link_url = apply_filters( 'hello_elementor_skip_link_url', '#content' );
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="<?php echo esc_attr( $viewport_content ); ?>">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>



    <!-- ======= Icons used for dropdown (you can use your own) ======== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <?php wp_head(); ?>


    <style>
    /* Important styles */
    #toggle {
        display: block;
        width: 28px;
        height: 30px;
        margin: 30px auto 10px;
    }

    #toggle span:after,
    #toggle span:before {
        content: "";
        position: absolute;
        left: 0;
        top: -9px;
    }

    #toggle span:after {
        top: 9px;
    }

    #toggle span {
        position: relative;
        display: block;
    }

    #toggle span,
    #toggle span:after,
    #toggle span:before {
        width: 100%;
        height: 5px;
        background-color: #888;
        transition: all 0.3s;
        backface-visibility: hidden;
        border-radius: 2px;
    }

    /* on activation */
    #toggle.on span {
        background-color: transparent;
    }

    #toggle.on span:before {
        transform: rotate(45deg) translate(5px, 5px);
    }

    #toggle.on span:after {
        transform: rotate(-45deg) translate(7px, -8px);
    }

    #toggle.on+#menu {
        opacity: 1;
        visibility: visible;
    }

    /* menu appearance*/
    #menu {
        position: relative;
        color: #999;
        width: 200px;
        padding: 10px;
        margin: auto;
        font-family: "Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif;
        text-align: center;
        border-radius: 4px;
        background: white;
        box-shadow: 0 1px 8px rgba(0, 0, 0, 0.05);
        /* just for this demo */
        opacity: 0;
        visibility: hidden;
        transition: opacity .4s;
    }

    #menu:after {
        position: absolute;
        top: -15px;
        left: 95px;
        content: "";
        display: block;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-bottom: 20px solid white;
    }

    ul,
    li,
    li a {
        list-style: none;
        display: block;
        margin: 0;
        padding: 0;
    }

    li a {
        padding: 5px;
        color: #888;
        text-decoration: none;
        transition: all .2s;
    }

    li a:hover,
    li a:focus {
        background: #1ABC9C;
        color: #fff;
    }


    /* demo styles */
    body {
        margin-top: 3em;
        background: #eee;
        color: #555;
        font-family: "Open Sans", "Segoe UI", Helvetica, Arial, sans-serif;
    }

    p,
    p a {
        font-size: 12px;
        text-align: center;
        color: #888;
    }

    .sidebar li .submenu {
        list-style: none;
        margin: 0;
        padding: 0;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .sidebar .nav-link {
        font-weight: 500;
        color: var(--bs-dark);
    }

    .sidebar .nav-link:hover {
        color: var(--bs-primary);
    }

    #toggle span,
    #toggle span:after,
    #toggle span:before {
        width: 100%;
        height: 6px;
        background-color: #0c0d0e;
        transition: all 0.3s;
        backface-visibility: hidden;
        border-radius: 2px;
    }

    #toggle {
        display: block;
        width: 28px;
        height: 30px;
        margin: 28px auto 8px;
        margin-left: 5px;
    }

    li a:hover,
    li a:focus {
        background: #1abc9c08;
        color: #fff;
    }

    .sidebar .nav-link:hover {
        color: #0e1012;
    }

    @media screen and (max-width: 768px) {

        #filtrosBienal {
            display: none;
        }

        #desplegableMenu {
            margin-left: 80px;
        }

        #america {
            transform: scale(0.68) translate(-300px, -68px) !important;
        }
    }
    </style>
</head>

<body <?php body_class(); ?>>
    <header>



    </header>


    <div class="row" style="background-color: #ffffff00;height: 75px;position:relative;z-index: 999;">
        <div class="row" style="height: 75px;position:fixed;z-index: 999;">
            <div class="col-lg-1">
                <p id="anoGuardado" style="
    margin: auto;
    text-align: center;
    font-size: 40px;
    font-weight: 900;
    color: black;
">1971</p>
            </div>

            <div id="desplegableMenu" class="col-lg-1">
                <a href="#menu" id="toggle"><span></span></a>


                <div style="margin-left: -91px;" id="menu">
                    <ul class="nav flex-column sidebar" id="nav_accordion">
                        <li><a class="nav-link" href="https://bienales.museolatertulia.com/">Inicio </a></li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" style="font-size: 21px;" href=""> 1971 </a>
                            <ul class="submenu collapse">
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" onclick="irMapa('1971'); return false;">mapa </a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="https://bienales.museolatertulia.com/mapaview/?_bienales=i-bienal">bienal</a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">categorias</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">artistas</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">recursos</a> </li>

                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" style="font-size: 21px;" href="#"> 1973</a>
                            <ul class="submenu collapse">
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" onclick="irMapa('1973'); return false;">mapa </a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="https://bienales.museolatertulia.com/mapaview/?_bienales=ii-bienal">bienal</a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">categorias</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">artistas</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">recursos</a> </li>

                            </ul>
                        </li>
                        <li class="nav-item has-submenu">
                            <a class="nav-link" style="font-size: 21px;" href="#"> 1976 </a>
                            <ul class="submenu collapse">
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" onclick="irMapa('1976');">mapa </a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="https://bienales.museolatertulia.com/mapaview/?_bienales=iii-bienal">bienal</a></li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">categorias</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">artistas</a> </li>
                                <li style="margin-left: 50px;text-align: start;"><a class="nav-link" href="#">recursos</a> </li>

                            </ul>
                        </li>
                    </ul>

                </div>

            </div>
            <div class="col-lg-5">
            </div>
            <div id="filtrosBienal" class="col-lg-5">
                <div class="row" style="margin-top: 20px;">
                    <div class="col-lg-3">
                        <?php
      if (function_exists('facetwp_display')) {
          echo facetwp_display('facet', 'bienales');
      }
      ?>
                    </div>
                    <div class="col-lg-3">
                        <?php
      if (function_exists('facetwp_display')) {
          echo facetwp_display('facet', 'artistas');
      }
      ?>
                    </div>
                    <div class="col-lg-3">
                        <?php
      if (function_exists('facetwp_display')) {
          echo facetwp_display('facet', 'tcnicas');
      }
      ?>
                    </div>
                    <div class="col-lg-3">
                        <?php
      if (function_exists('facetwp_display')) {
          echo facetwp_display('facet', 'pases');
      }
      ?>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <script>
    var theToggle = document.getElementById('toggle');

    // based on Todd Motto functions
    // https://toddmotto.com/labs/reusable-js/

    // hasClass
    function hasClass(elem, className) {
        return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
    }
    // addClass
    function addClass(elem, className) {
        if (!hasClass(elem, className)) {
            elem.className += ' ' + className;
        }
    }
    // removeClass
    function removeClass(elem, className) {
        var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, ' ') + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(' ' + className + ' ') >= 0) {
                newClass = newClass.replace(' ' + className + ' ', ' ');
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        }
    }
    // toggleClass
    function toggleClass(elem, className) {
        var newClass = ' ' + elem.className.replace(/[\t\r\n]/g, " ") + ' ';
        if (hasClass(elem, className)) {
            while (newClass.indexOf(" " + className + " ") >= 0) {
                newClass = newClass.replace(" " + className + " ", " ");
            }
            elem.className = newClass.replace(/^\s+|\s+$/g, '');
        } else {
            elem.className += ' ' + className;
        }
    }

    theToggle.onclick = function() {
        toggleClass(this, 'on');
        return false;
    }

    function irMapa(ano) {
        var url = "https://bienales.museolatertulia.com/mapaview/?_bienales=i-bienal";

        if (ano == "1971") {
            url = "https://bienales.museolatertulia.com/mapaview/?_bienales=i-bienal";
            localStorage.setItem('anoGuardado', '1971');
        }
        if (ano == "1973") {
            url = "https://bienales.museolatertulia.com/mapaview/?_bienales=ii-bienal";
            localStorage.setItem('anoGuardado', '1973');
        }
        if (ano == "1976") {
            url = "https://bienales.museolatertulia.com/mapaview/?_bienales=iii-bienal";
            localStorage.setItem('anoGuardado', '1976');
        }
        window.location.href = url;
    }
    document.addEventListener("DOMContentLoaded", function() {

        var anoGuardado = localStorage.getItem('anoGuardado');

        if (anoGuardado === null) {

        } else {
            if (anoGuardado == "1971") {
                var parrafo = document.getElementById("anoGuardado");
                parrafo.textContent = "1971";
            }
            if (anoGuardado == "1973") {
                var parrafo = document.getElementById("anoGuardado");
                parrafo.textContent = "1973";
            }
            if (anoGuardado == "1976") {
                var parrafo = document.getElementById("anoGuardado");
                parrafo.textContent = "1976";
            }
        }


        document.querySelectorAll('.sidebar .nav-link').forEach(function(element) {

            element.addEventListener('click', function(e) {

                let nextEl = element.nextElementSibling;
                let parentEl = element.parentElement;

                if (nextEl) {
                    e.preventDefault();
                    let mycollapse = new bootstrap.Collapse(nextEl);

                    if (nextEl.classList.contains('show')) {
                        mycollapse.hide();
                    } else {
                        mycollapse.show();
                        // find other submenus with class=show
                        var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                        // if it exists, then close all of them
                        if (opened_submenu) {
                            new bootstrap.Collapse(opened_submenu);
                        }

                    }
                }

            });
        })

    });
    </script>