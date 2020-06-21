<?php
//TODO queryselector js
use application\controllers\AdminController;
$id = $parameters['gigs_id'];
?>
<div style="width: 500px"></div>
<form action="/admin/gigs/edit/<?php echo $id;?>" id="admin-gigs-form" method="post">
    <div class="form-group column">
        <div class="form-group row">
        <label for="admin-gigs-date" class="col-2 col-form-label">Date and time:</label>
        <div class="col-8 col-lg-4">
        <input class="form-control"  type="datetime-local"
               value="<?php echo substr($parameters['gigs_date'], 0,10)."T".substr($parameters['gigs_date'], 11,9);?>"
               id="admin-gigs-date" name="gigs_date">
        </div>
        </div>
        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Country:</label>
        <div class="col-8 col-lg-4">

            <select class="form-control form-control-sm" id="admin-gigs-country" name="gigs_country">
                <?php
                $arrayOfCountries= require "application/config/country.php";
                foreach ($arrayOfCountries as $code=>$name){
                    if ($name===$parameters['gigs_country']){
                        echo "<option selected='selected' value='".$parameters['gigs_country']."'>".$name."</option>";
                    }else{
                        echo "<option>".$name."</option>";
                    //TODO pass destructor topic
                    }
                }
                ?>
            </select>
        </div>
        </div>

            <div class="form-group row">
                <label for="example-datetime-local-input" class="col-2 col-form-label">City:</label>
                <div class="col-8 col-lg-4">
                    <input id="admin-gigs-city" class="form-control" type="text" value="<?php echo htmlspecialchars($parameters['gigs_city'], ENT_QUOTES); ?>" name="gigs_city">
                </div>
            </div>

        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Address:</label>
            <div class="col-8 col-lg-4">
                <input id="admin-gigs-address" class="form-control" type="text" value="<?php echo htmlspecialchars($parameters['gigs_address'], ENT_QUOTES); ?>" name="gigs_address">
            </div>
        </div>

        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Description:</label>
            <div class="col-8 col-lg-4">
                <textarea id="admin-gigs-description" class="form-control" rows="3" name="gigs_description"><?php echo htmlspecialchars($parameters['gigs_description'], ENT_QUOTES); ?></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="admin-gigs-drop-input" class="col-2 col-form-label">Poster:</label>
            <div  class="col-8 col-lg-4">
<!--                <div class="col-10 col-lg-6" id="admin-gigs-drop-area">-->
<!--                    <div class="admin-gigs-drop-form">-->
                <input type="file" style="display: none" id="admin-gigs-drop-input" accept="image/*" >
                <label id="admin-gigs-drop-label"  style="float: left" for="admin-gigs-drop-input">Upload image</label>
<!--                        <div class="admin-drop-button-wrapper">-->
<!--                            <span class="admin-drop-inscription">Move your file here or&nbsp</span>-->
<!--                            <label class="admin-drop-button" for="admin-drop-input">select a file</label>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div id="gallery"></div>-->
<!--                </div>-->
          </div>
        </div>

        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label">Links:</label>
            <div class="col-4 col-lg-2">
                <button class="btn btn-success btn-block" id="admin-add-button">Add link</button>
            </div>
        </div>

        <div class="form-group row">
            <label for="example-datetime-local-input" class="col-2 col-form-label"></label>
            <div class="col-4 col-lg-2">
                 <button type="submit" class="btn btn-success btn-block" id="admin-gig-submit">Save</button>
            </div>
        </div>
    </div>
</form>
<script src="/public/scripts/editGig.js"></script>
