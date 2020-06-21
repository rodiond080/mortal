<div class="news-main">
    <div class="news-main-1-head-picture"></div>
    <div class="news-main-2">NEWS</div>
    <div class="container-fluid-my-nav">
        <div class="news-main-middle col-lg-8">
            <?=$pagination?>
        </div>
    </div>

<!--    <div class="container">-->
        <div class="container-fluid-my row justify-content-lg-center">

        <?php
            for($i=0;$i<sizeof($parameters); $i++){
                if ($i%2==0){

                    echo "<div class=\"news-item col col-lg-2 d-none d-lg-block\"></div>

    <div class=\"news-item col-4 col-lg-4\">
        <div class=\"news-item-picture\"></div>
        <div class=\"news-item-content\">
            <div class=\"news-item-date\">". strtoupper(date('M d, Y', strtotime($parameters[$i]['news_date'])))."</div>
            <div class=\"news-item-heading\">".$parameters[$i]['news_heading']."</div>
            <div class=\"news-item-text\">".substr($parameters[$i]['news_content'], 0, 100)."</div>
            <div class=\"news-item-button\">button</div>
        </div>
    </div>";
                }else{
                    echo "
    <div class=\"news-item col-4 col-lg-4\">
        <div class=\"news-item-picture\"></div>
        <div class=\"news-item-content\">
            <div class=\"news-item-date\">". strtoupper(date('M d, Y', strtotime($parameters[$i]['news_date'])))."</div>
            <div class=\"news-item-heading\">".$parameters[$i]['news_heading']."</div>
            <div class=\"news-item-text\">".substr($parameters[$i]['news_content'], 0, 100)."</div>
            <div class=\"news-item-button\">button</div>
        </div>
    </div> <div class=\"news-item col col-lg-2 d-none d-lg-block\"></div>";
                }

                if($i==sizeof($parameters)-1 && $i%2==0){
                    echo "<div class=\"news-item col-4 col-lg-4\"></div>";
                    echo "<div class=\"news-item col col-lg-2 d-none d-lg-block\"></div>";
                }
            }
        ?>


        </div>


</div>















