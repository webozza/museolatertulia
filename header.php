<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- panZoom  CDN-->
    <script src="https://unpkg.com/@panzoom/panzoom@4.5.1/dist/panzoom.min.js"></script>

    <!-- ======= Icons used for dropdown (you can use your own) ======== -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <?php wp_head()?>
</head>
<body <?php body_class()?>>

<div class="header-left">
    <div class="logo-container">
        <div class="logo"><h1>1971</h1></div>
        <div class="toggle-menue">
            <span></span>
        </div>
    </div>
</div>
<div class="header-right">
        <div class="menu">
            <ul>
                <li>Bienal</li>
                <li>Artista</li>
                <li>País</li>
                <li>Categoría</li>
            </ul>
        </div>
    </div>


    <script>

        $(document).ready(function(){


            var theToggle = $('.toggle-menue');
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
                    console.log('clicked')
                    return false;
                }


        })

    </script>