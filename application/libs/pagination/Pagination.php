<?php
namespace application\libs\pagination;

interface  Pagination{
    public function getPages($id, $numberOfNews, $numberOfNewsPerPage);
}