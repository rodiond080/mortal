<div class="admin-audio-edit-main">
    <form action="#">
    <div class="form-group row">
        <label for="admin-audioalbum-name" class="col-2 col-form-label">Audioalbum name:</label>
        <div class="col-10 col-lg-6">
            <input id="admin-audioalbum-name" class="form-control" type="text" >
        </div>
    </div>


        <div class="form-group row">
            <label for="" class="col-2 ">Poster:</label>
            <div  class="col-2 col-lg-2">
                <input type="file" style="display: none" id="admin-audioalbum-poster-input" accept="image/*" >
                <label id="admin-audioalbum-poster-label"    for="admin-audioalbum-poster-input">Upload image</label>
            </div>
            <div class="admin-audioalbum-poster-box" id="admin-audioalbum-poster-box"></div>
            
        </div>



    <div id="admin-audio-edit-area" class="admin-audio-edit-area">

        <div class="admin-audio-label-wrapper">
            <input type="file" multiple  accept="audio/*" id="admin-audio-edit-input">Put on your photos here or
            <label id="admin-audio-edit-label" for="admin-audio-edit-input"> choose the file</label>
        </div>



        <div id="admin-audio-edit-trackbox" class="row">
            <!--              <div draggable="true" class="col-6 col-sm-6 col-md-4 col-lg-2">-->
            <!--                     <div class="admin-audio-edit-item-box">-->
            <!--                           <div class="admin-audio-edit-item">-->
            <!--                                <div class="admin-audio-edit-content">-->
            <!--                                    <div class="admin-audio-edit-closer">-->
            <!--                                        <div class="admin-news-edit-x"></div>-->
            <!--                                    </div>-->
            <!--                                 </div>-->
            <!--                           </div>-->
            <!--                     </div>-->
            <!--              </div>-->
        </div>
    </div>
    <button class="btn btn-success" id="admin-audio-button-save">Save</button>
    </form>
</div>
<script type="module" src="/public/scripts/editAudioAlbum.js"></script>