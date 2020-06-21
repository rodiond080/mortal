<div class="gigs-main">
        <div class="gigs-head-picture">
        </div>

        <div class="gigs-list  col col-lg-9">
        <div class="gigs-selector-wrapper">
            <div class="gigs-selector-heading">
                Gigs for the year <?=$parameters['year']?>
            </div>

            <select class="gigs-selector" onchange="top.location=this.value" name="year" id="">
                <?php
                    foreach ($parameters['years'] as $year){
                        if($year['year']==$parameters['year']){
                            echo "<option selected='selected' value='/gigs/year/".$year['year']."'>".$year['year']."</option>";
                        }else{
                            echo "<option value='/gigs/year/".$year['year']."'>".$year['year']."</option>";
                        }
                    }
                ?>
            </select>
        </div>

            <ul class="gigs-gigs-list">
                    <li class="gigs-year col"><?=$parameters['year']?></li>

                <?php
                    for($i=0; $i<sizeof($parameters['gigs']); $i++){
                        $isLaterThanNow =  $parameters['gigs'][$i]['gigs_date']>date("Y-m-d H:i:s");

                        if($i!=0){
                            $prevMonth = date("F", strtotime(substr($parameters['gigs'][$i-1]['gigs_date'], 0, 10)));
                        }
                        $month = date("F", strtotime(substr($parameters['gigs'][$i]['gigs_date'], 0, 10)));
                        if($i==0 || $month!=$prevMonth){
                            echo "<li class=\"gigs-month col\">".$month."</li>";
                        }

                        echo "<li class=\"gigs-gigs-item\">";
                        echo "<div class=\"gigs-event location col col-lg-1\">"
                            .date("D", strtotime(substr($parameters['gigs'][$i]['gigs_date'], 0,10.)))." "
                            .date("j", strtotime(substr($parameters['gigs'][$i]['gigs_date'], 0,10.)))
                            ."</div>";
                        echo "<div class=\"gigs-event location col col-lg-2\">"
                            .$parameters['gigs'][$i]['gigs_city'].", "
                            .$parameters['gigs'][$i]['gigs_country']
                            ."</div>";
                        echo "<div class=\"gigs-event venue col col-lg-3\">".$parameters['gigs'][$i]['gigs_address']."</div>";
                        if($isLaterThanNow){
                            echo "<div class=\"gigs-event links col col-lg-1\"><a href=\"#\">Buy a ticket</a></div>";
                        }
                        echo "<div class=\"gigs-event poster col col-lg-1\">img</div>";
                        echo "<div class=\"gigs-event description col col-lg-4\">".$parameters['gigs'][$i]['gigs_description']."</div>";
                        if(!$isLaterThanNow){
                            echo "<div class=\"gigs-event review col col-lg-1\"><a href=\"#\" >review</a></div>";
                        }
                        echo "</li>";

                    }
                ?>
<!--                    <li class="gigs-month col">May</li>-->
<!--                <li class="gigs-gigs-item">-->
<!--                    <div class="gigs-event date col col-lg-1">Fri 1</div>-->
<!--                    <div class="gigs-event location col col-lg-2">Moscow, Russia</div>-->
<!--                    <div class="gigs-event venue col col-lg-3">Red square</div>-->
<!--                    <div class="gigs-event links col col-lg-1"><a href="#">Buy a ticket</a></div>-->
<!--                    <div class="gigs-event poster col col-lg-1">img</div>-->
<!--                    <div class="gigs-event description col col-lg-4">The fucking large show! Tolyapa is going to belch much!</div>-->
<!--                    <div class="gigs-event review col col-lg-1"><a href="#" >review</a></div>-->
<!--                </li>-->




<!--                <li class="gigs-gigs-item">-->
<!--                    <div class="gigs-event date col col-lg-1">Fri 1</div>-->
<!--                    <div class="gigs-event location col col-lg-2">Moscow, Russia</div>-->
<!--                    <div class="gigs-event venue col col-lg-3">Red square</div>-->
<!--                    <div class="gigs-event links col col-lg-1"><a href="#">Buy a ticket</a></div>-->
<!--                    <div class="gigs-event poster col col-lg-1">img</div>-->
<!--                    <div class="gigs-event description col col-lg-4">The fucking large show! Tolyapa is going to belch much!</div>-->
<!--                                        <div class="gigs-event review col col-lg-1"><a href="#" >review</a></div>-->
<!--                </li>-->
<!---->
<!---->
<!---->
<!---->
<!--                <li class="gigs-gigs-item">-->
<!--                    <div class="gigs-event date col col-lg-1">Fri 1</div>-->
<!--                    <div class="gigs-event location col col-lg-2">Moscow, Russia</div>-->
<!--                    <div class="gigs-event venue col col-lg-3">Red square</div>-->
<!--                    <div class="gigs-event links col col-lg-1"><a href="#">Buy a ticket</a></div>-->
<!--                    <div class="gigs-event poster col col-lg-1">img</div>-->
<!--                    <div class="gigs-event description col col-lg-4">The fucking large show! Tolyapa is going to belch much!</div>-->
                    <!--                    <div class="gigs-event review col col-lg-1"><a href="#" >review</a></div>-->
<!--                </li>-->
<!---->
<!---->
<!---->
<!---->
<!--                <li class="gigs-gigs-item">-->
<!--                    <div class="gigs-event date col col-lg-1">Fri 1</div>-->
<!--                    <div class="gigs-event location col col-lg-2">Moscow, Russia</div>-->
<!--                    <div class="gigs-event venue col col-lg-3">Red square</div>-->
<!--                    <div class="gigs-event links col col-lg-1"><a href="#">Buy a ticket</a></div>-->
<!--                    <div class="gigs-event poster col col-lg-1">img</div>-->
<!--                    <div class="gigs-event description col col-lg-4">The fucking large show! Tolyapa is going to belch much!</div>-->
                    <!--                    <div class="gigs-event review col col-lg-1"><a href="#" >review</a></div>-->
<!--                </li>-->
<!---->
<!---->
<!---->
<!---->
<!--                <li class="gigs-gigs-item">-->
<!--                    <div class="gigs-event date col col-lg-1">Fri 1</div>-->
<!--                    <div class="gigs-event location col col-lg-2">Moscow, Russia</div>-->
<!--                    <div class="gigs-event venue col col-lg-3">Red square</div>-->
<!--                    <div class="gigs-event links col col-lg-1"><a href="#">Buy a ticket</a></div>-->
<!--                    <div class="gigs-event poster col col-lg-1">img</div>-->
<!--                    <div class="gigs-event description col col-lg-4">The fucking large show! Tolyapa is going to belch much!</div>-->
                    <!--                    <div class="gigs-event review col col-lg-1"><a href="#" >review</a></div>-->
<!--                </li>-->


            </ul>
        </div>



</div>