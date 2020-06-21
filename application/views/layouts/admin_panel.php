<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="/public/styles/admin_panel.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <title><?=$title ?></title>
</head>
<body>
<div class="admin-main">
    <div class="admin-main2-wrapper">
        <div class="admin-main2">
            <div class="admin-main2-header">
                <img src="/public/images/front/logo2.png" height="100">
            </div>
            <div class="admin-main2-content">
                <?=$content ?>
            </div>
        </div>
    </div>
    <div class="admin-main1">
        <input type="checkbox" id="check">
        <label for="check">
            <i class="fas fa-bars" id="btn"></i>
            <i class="fas fa-times" id="cancel"></i>
        </label>

        <div class="sidebar">
            <header><?=$title ?></header>
            <ul>
                <li><a href="/admin/news/index/1" class="admin-link"><i class="fas fa-qrcode"></i>News</a></li>
                <li><a href="/admin/gigs/index/1" class="admin-link"><i class="fas fa-link"></i>Gigs</a></li>
                <li class="dropdown">
                    <a href="#" id="admin-link-media" class="admin-link dropdown-toggle "><i class="fas fa-stream"></i>Media</a>
                    <div id="admin-links-media-box">
                        <div id="admin-links-media" class="admin-links-media">
                         <a class="admin-link-media" href="/admin/photoalbums"><i class="fas"></i>Photo</a>
                         <a class="admin-link-media" href="/admin/audioalbums"><i class="fas "></i>Audio</a>
                        </div>
                    </div>

                </li>
                <li><a href="/admin/contact" class="admin-link"><i class="fas fa-calendar-week"></i>Contacts</a></li>
                <li><a href="/admin/contact" class="admin-link"><i class="fas fa-logout"></i>Log out</a></li>
            </ul>
        </div>
    </div>
</div>
<script src="/public/scripts/admin.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>