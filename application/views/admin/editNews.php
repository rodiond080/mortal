<?php
$paginationIndex = basename($_SERVER['REQUEST_URI'], '?');
?>
<div class="admin-news-table ">

<!--<table class=" table table-hover table-sm">-->
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Date</th>
        <th scope="col">Heading</th>
        <th scope="col">Text</th>
        <th scope="col">Pictures</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($parameters as $key=>$val){
        $newsId = $parameters[$key]['news_id'];
        $newsDate = $parameters[$key]['news_date'];
        $newsHeading = (strlen($parameters[$key]['news_heading'])>20)
                ?substr($parameters[$key]['news_heading'],0,10).'...'
                :$parameters[$key]['news_heading'];
        $newsContent = (strlen($parameters[$key]['news_content'])>20)
                ?substr($parameters[$key]['news_content'],0,10).'...'
                :$parameters[$key]['news_content'];

        $imgDir="public/images/news/news".substr($newsDate,0,10).'id'.$newsId;
        if(is_dir($imgDir)){
            $listOfFiles= scandir($imgDir);
            foreach ($listOfFiles as $file){
                if($file!='..' && $file!='.'){
                    $newsPictures = "<img class=\"admin-news-img\" src=\"/".$imgDir."/".$file."\">";
                }
            }

        }else{
            $newsPictures = "-";
        }



        echo "<tr>";
        echo "<th scope=\"row\">".substr($newsDate,0,10) ."</th>";
        echo "<td>".$newsHeading."</td>";
        echo "<td>".$newsContent."</td>";
        echo "<td>".$newsPictures."</td>";

        //buttons
        echo "<form action='/admin/news/edit/".$newsId."'>";
        echo "<td><button type=\"submit\" class=\"btn btn-secondary\">Edit</button></td>";
        echo "</form>";
        echo "<form method=\"post\" action='/admin/news/delete/".$newsId."'>";
        echo "<td><button name='index' value='".$paginationIndex."' type=\"submit\" class=\"btn btn-danger\">Delete</button></td>";
        echo "</form>";
        echo "</tr>";
    }
    ?>

    </tbody>
</table>
</div>
<hr>

<form action="/admin/news/new">
<div class="admin-news-button-pagination-wrapper">
    <button type="submit" class="btn btn-success">Add news</button>
    <div class="admin-news-pagination"><?php echo $pagination;?></div>
</div>
</form>
