<?php
$id = $parameters['news_id'];
//TODO for what do we use a tag "span"?
?>

<form action="/admin/news/edit/<?=$id?>" id="admin-news-form" method="post" enctype="multipart/form-data">
    <div class="form-group column admin-news-content">
        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Date and time:</label>
            <div class="col-10 col-lg-6">
                <input class="form-control"  type="datetime-local"
                       value="<?php echo substr($parameters['news_date'], 0,10)."T".substr($parameters['news_date'], 11,9);?>"
                       id="admin-news-date" name="news_date">
            </div>
        </div>
        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Heading:</label>
            <div class="col-10 col-lg-6">
              <input id="admin-onenews-heading" class="form-control" type="text" value="<?php echo htmlspecialchars($parameters['news_heading'], ENT_QUOTES); ?>" name="news_city">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Description:</label>
            <div class="col-10 col-lg-6">
                <textarea id="admin-onenews-description" class="form-control" rows="3" name="news_description"><?php echo htmlspecialchars($parameters['news_content'], ENT_QUOTES); ?></textarea>
            </div>
        </div>

<!--    <div class="form-group row">-->

        <div id="admin-onenews-edit-area" class="admin-onenews-imginput-area">
            <div class="admin-onenews-imginput-wrapper">
                <input type="file" multiple  accept="image/*" id="admin-onenews-imginput-input">Put on your photos here or
                <label id="admin-onenews-label" for="admin-onenews-imginput-input"> choose the file</label>
            </div>

            <div id="admin-onenews-box" class="row">
<!--                            <div class="admin-sketch-width col-6 col-sm-4 col-md-3 col-lg-2 col-xl-1 ">-->
<!---->
<!--                                <div class="admin-sketch-wrapper">-->
<!--                                    <div class="admin-sketch-content">-->
<!--                                        <div class="admin-sketch-name"></div>-->
<!---->
<!--                                        <div class="admin-sketch-progress-and-closer">-->
<!--                                            <div class="admin-sketch-progress">-->
<!--                                                <div class="admin-sketch-indicator"></div>-->
<!--                                            </div>-->
<!--                                            <div class="admin-sketch-closer">-->
<!--                                                <div class="admin-sketch-x"></div>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!---->
<!--                                        <div class="admin-sketch-title"></div>-->
<!---->
<!--                            <input type="radio" id="admin-sketch-radio" name="contact" value="email">-->
<!--                            <label for="admin-sketch-radio">cover</label>-->
<!---->
<!---->
<!--                                    </div>-->
<!---->
<!--                                </div>-->
<!---->
<!--                            </div>-->

            </div>
        </div>




        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label"></label>
            <div class="col-4 col-lg-2">
                <button type="submit" class="btn btn-success btn-block" id="admin-onenews-savebutton">Save</button>
            </div>
        </div>
    </div>
</form>
<script type="module" src="/public/scripts/editOneNews.js"></script>
