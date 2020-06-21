<?php
$paginationIndex = basename($_SERVER['REQUEST_URI'], '?');
?>
<div class="admin-news-table  table-responsive-sm">
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Date</th>
        <th scope="col">Address</th>
        <th scope="col">City</th>
        <th scope="col">Country</th>
        <th scope="col">Description</th>
        <th scope="col">Poster</th>
        <th scope="col">Links</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>

    <?php
        foreach ($parameters as $key=>$val){
            $gigsDate = $parameters[$key]['gigs_date'];
            $gigsAddress = $parameters[$key]['gigs_address'];
            $gigsCity = $parameters[$key]['gigs_city'];
            $gigsCountry = $parameters[$key]['gigs_country'];
            $gigsDescription = $parameters[$key]['gigs_description'];
//            $gigsLink1 = $parameters[$key]['gigs_link1'];
//            $gigsLink2 = $parameters[$key]['gigs_link2'];
            $gigsId = $parameters[$key]['gigs_id'];


            echo "<tr>";
            echo "<th scope=\"row\">".$gigsDate."</th>";
            echo "<td>".$gigsAddress."</td>";
            echo "<td>".$gigsCity."</td>";
            echo "<td>".$gigsCountry."</td>";
            echo "<td>".$gigsDescription."</td>";
            echo "<td>"."img"."</td>";
            echo "<td>"."links"."</td>";


            //buttons
            echo "<form action='/admin/gigs/edit/".$gigsId."'>";
            echo "<td><button type=\"submit\" class=\"btn btn-secondary\">Edit</button></td>";
            echo "</form>";
            echo "<form method=\"post\" action='/admin/gigs/delete/".$gigsId."'>";
            echo "<td><button name='index' value='".$paginationIndex."' type=\"submit\" class=\"btn btn-danger\">Delete</button></td>";
            echo "</form>";
            echo "</tr>";
        }
    ?>
    </tbody>

</table>
<hr>

<!--<button type="button" class="btn btn-success">New gig</button>-->
</div>
<form action="/admin/gigs/new">
    <div class="admin-news-button-pagination-wrapper">
        <button type="submit" class="btn btn-success">Add gig</button>
        <div class="admin-news-pagination"><?php echo $pagination;?></div>
    </div>
</form>