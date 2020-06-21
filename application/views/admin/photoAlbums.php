<div class="admin-photo-main">
    Albums:
    <div class="admin-albums-box ">
        <div class="row">
            <?php
            foreach ($parameters as $album){
                echo "<a href=\"/admin/photoalbums/index/".$album['photo_albums_id']."\" class=\"admin-album-item-box col-xl-2 col-sm-4 col-6\">";
                echo "<div href=\"#\" class=\"admin-album-item\">";
                echo "<div class=\"admin-album-content\">";
                echo  $album['photo_albums_name'];
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
            ?>


<!--            <a href="#" class="admin-album-item-box col-xl-2 col-sm-4 col-6">-->
<!--                <div href="#" class="admin-album-item">-->
<!--                    <div class="admin-album-content">-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!--            </a>-->




        </div>
    </div>
    <form action="/admin/photoalbums/new">
        <div id="admin-albumname-form" style="display: none" class="form-group">
            <label for="admin-albumname-form-input">Enter the name of a new album:</label>
            <input type="email" class="form-control" id="admin-albumname-form-input" aria-describedby="emailHelp" placeholder="Album name">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <button type="submit" id="admin-albumname-form-button" class="btn btn-success">Ok</button>
        </div>

    <button class="btn btn-success" id="admin-photo-button-add">Add album</button>
</div>
<script src="/public/scripts/editPhotos.js"></script>