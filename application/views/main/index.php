<div class="main-1-firstView">
    <a href="#">Mörtal</a>
</div>

<div class="main-2-container">
    <div class="main-2-news">

        Latest news:
        <hr>

        <a href="#">
        <div class="main-2-news-item">

            <div class="main-2-news-item-circle-wraper">
                    <div class="main-2-news-item-circle">
                        <div>09</div>
                        <div>24</div>
                    </div>
            </div>

            <div class="main-2-news-item-header">
                On the first gig the former guitarist came and made there a fracas
            </div>
        </div>
        </a>

    </div>

    <div class="main-2-gigs">
        Upcoming gigs:
        <hr>
        <a href="#">
            <div class="main-2-gigs-item">

                <div class="main-2-gigs-item-circle-wraper">
                    <div class="main-2-gigs-item-circle">
                        <div>09</div>
                        <div>24</div>
                    </div>
                </div>


                <div class="main-2-gigs-item-description-place-wraper">
                    <div class="main-2-gigs-item-place">
                        Red Square, Moscow, Russia
                    </div>

                    <div class="main-2-gigs-item-description">
                        Mörtal's large show
                    </div>
                </div>
            </div>

        </a>


        <?php
        $counter = 0;
        foreach ($parameters as $key => $gig){

            echo "<a href=\"#\">";
            echo "<div class=\"main-2-gigs-item\">";
            echo "<div class=\"main-2-gigs-item-circle-wraper\">";
            echo "<div class=\"main-2-gigs-item-circle\">";
            echo "<div>".substr($gig['gigs_date'], 8,2)."</div>";
            echo "<div>".substr($gig['gigs_date'], 5,2)."</div>";
            echo "</div>";
            echo "</div>";
            echo "<div class=\"main-2-gigs-item-description-place-wraper\">";
            echo "<div class=\"main-2-gigs-item-place\">";
            echo $gig['gigs_address'].", ".$gig['gigs_city'].", ".$gig['gigs_country'];
            echo   "</div>";
            echo  "<div class=\"main-2-gigs-item-description\">";
            echo   $gig['gigs_description'];
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</a>";
            $counter++;
            //TODO in the table "gigs" make "gigs_id" the first
            if ($counter>3){
                break;
            }
        }

        echo $pagination;
        ?>


    </div>

    <div class="main-2-random-song">
        Random song:
    </div>
</div>