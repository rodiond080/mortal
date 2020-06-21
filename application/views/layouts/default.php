<?php
$db = new \application\libs\DB();
$lastYear= $db->makeQuery("SELECT YEAR(gigs_date) as year FROM gigs GROUP BY year ORDER BY YEAR(gigs_date) DESC")[0];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title;?></title>

    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
    <link href="https://fonts.googleapis.com/css?family=Eater&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Amatic+SC&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan+2&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="/public/styles/default.css" rel="stylesheet" type="text/css">
    <script src="/public/scripts/jquery-3.4.1.min.js"></script>

</head>
<body>
<header>
    <nav>
        <ul class="main-main-nav" id="id-main-main-nav">

            <li><a  href="/news/index/1" class="main-nav-active-link admin-link">News</a></li>
            <li><a   href="/gigs/year/<?php echo $lastYear['year'];?>" class="main-nav-active-link admin-link">Gigs</a></li>

            <li>
                <a   href="/" class="main-nav-active-link logo admin-link">
                    <img src="../../../public/images/front/logo2.png" height="100">
                </a>
            </li>
            <li>
                <a   href="/" class="main-nav-active-link admin-link">Media</a>
                <div class="main-media">
                    <div>
                    <a class="admin-media-a" href="/media/photo">Photo</a>
                    <a class="admin-media-a" href="/media/audio">Audio</a>
                    </div>
                </div>
            </li>
            <li><a href="/contact" class="main-nav-active-link admin-link">Contact</a></li>
            <li class="main-nav-icon admin-link" id="id-main-nav-icon"><a href="javascript:void (0);">&#9776</a></li>
        </ul>

<!---->
<!--        <ul class="main-main-nav" id="id-main-main-nav">-->
<!---->
<!--            <li><a  href="/news/index/1" class="main-nav-active-link admin-link">News</a></li>-->
<!--            <li><a   href="/gigs/year/--><?php //echo $lastYear['year'];?><!--" class="main-nav-active-link admin-link">Gigs</a></li>-->
<!---->
<!--            <li>-->
<!--                <a   href="/" class="main-nav-active-link logo admin-link">-->
<!--                    <img src="../../../public/images/front/logo2.png" height="100">-->
<!--                </a>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a   href="/" class="main-nav-active-link admin-link">Media</a>-->
<!--                <div class="main-media">-->
<!--                    <div>-->
<!--                        <a class="admin-media-a" href="/media/photo">Photo</a>-->
<!--                        <a class="admin-media-a" href="/media/audio">Audio</a>-->
<!--                        <a class="admin-media-a" href="/media/video">Video</a>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </li>-->
<!--            <li><a href="/contact" class="main-nav-active-link admin-link">Contact</a></li>-->
<!--            <li class="main-nav-icon admin-link" id="id-main-nav-icon"><a href="javascript:void (0);">&#9776</a></li>-->
<!--        </ul>-->
<!--        -->

    </nav>
</header>


<?php
    echo $content;
?>



<footer>
    <div>
        <a href="https://www.youtube.com/channel/UCmXA2vsdP9I-t70CB53qIww" title="Youtube" ><img src="../../../public/images/front/youtube.png" height="28px" style="margin-top:;"></a>
        <a href="https://vk.com/club156446011" title="VK" ><img src="../../../public/images/front/vk.png" height="28px" style="margin-top:;"></a>
        <a href="https://www.facebook.com/groups/mortalspeedpunk/" title="Facebook" ><img src="../../../public/images/front/fb.png" height="28px" style="margin-top:;"></a>
        <a href="https://www.instagram.com/mortal_band_spb/" title="Instagram" ><img src="../../../public/images/front/inst.png" height="28px" style="margin-top:;"></a>
    </div>
    <div>Mörtal (c) all rights reserved.</div>
</footer>

<script src="/public/scripts/form.js"></script>
</body>
</html>