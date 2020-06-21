<div class="admin-audio-main">
    Albums:
    <div class="admin-audioalbums-box row ">

            <?php
            foreach ($parameters as $album){
                echo "<a href=\"/admin/audioalbums/index/".$album['audio_albums_id']."\" class=\"admin-audioalbum-box col-xl-2 col-sm-4 col-6\">";
                echo "<div href=\"#\" class=\"admin-audioalbums-wrapper\">";
                echo "<div class=\"admin-audioalbums-content\">";
                echo  $album['audio_albums_name'];
                echo "</div>";
                echo "</div>";
                echo "</a>";
            }
            ?>

<!--            <a href="#" class="admin-audio-item-box col-xl-2 col-sm-4 col-6">-->
<!--                <div href="#" class="admin-audio-item">-->
<!--                    <div href="#" class="admin-audio-item-content"></div>-->
<!--                </div>-->
<!--            </a>-->
<!---->
<!--            <a href="#" class="admin-audio-item-box col-xl-2 col-sm-4 col-6">-->
<!--                <div href="#" class="admin-audio-item">-->
<!--                    <div href="#" class="admin-audio-item-content"></div>-->
<!--                </div>-->
<!--            </a>-->


    </div>

    <form action="/admin/audioalbums/new">
        <div id="admin-audioname-form" style="display: none" class="form-group">
            <label for="admin-audioname-form-input">Enter the name of a new audio set:</label>
            <input type="email" class="form-control" id="admin-audioname-form-input" aria-describedby="emailHelp" placeholder="Album name">
<!--            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
            <button type="submit" id="admin-audioname-form-button" class="btn btn-success">Ok</button>
        </div>

        <button class="btn btn-success" id="admin-audio-button-add">Add album</button>
</div>
<script src="/public/scripts/editAudio.js"></script>