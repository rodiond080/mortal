<div class="admin-photo-edit-main">

    <div class="form-group row">
        <label for="admin-photoalbum-name" class="col-2 col-form-label">Photoalbum name:</label>
        <div class="col-10 col-lg-6">
            <input id="admin-photoalbum-name" class="form-control" type="text" >
        </div>
    </div>
    <div id="admin-photo-edit-area" class="admin-photo-edit-area">

        <div class="admin-photo-label-wrapper">
            <input type="file" multiple  accept="image/*" id="admin-photo-edit-input">Put on your photos here or
            <label id="admin-photo-edit-label" for="admin-photo-edit-input"> choose the file</label>
        </div>

        <div id="admin-photo-edit-imagesbox" class="row">
<!--            <div class="admin-sketch-width col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 ">-->
<!---->
<!--                <div class="admin-sketch-wrapper">-->
<!--                    <div class="admin-sketch-content">-->
<!--                        <div class="admin-sketch-name"></div>-->
<!---->
<!--                        <div class="admin-sketch-progress-and-closer">-->
<!--                            <div class="admin-sketch-progress">-->
<!--                                <div class="admin-sketch-indicator"></div>-->
<!--                            </div>-->
<!--                            <div class="admin-sketch-closer">-->
<!--                                <div class="admin-sketch-x"></div>-->
<!--                            </div>-->
<!--                        </div>-->
<!---->
<!--                        <div class="admin-sketch-title">-->
<!---->
<!--                        </div>-->
<!---->
<!--                    </div>-->
<!--                </div>-->
<!---->
<!--            </div>-->
        </div>
    </div>
    <button class="btn btn-success" id="admin-photo-button-save">Save</button>
</div>
<script type="module" src="/public/scripts/editPhotoAlbum.js"></script>