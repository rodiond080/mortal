<?php
namespace application\libs\pagination;
use application\libs\pagination\AmaticPagination;

class AmaticPaginationMaker extends PaginationMaker{
    public function getPagination(): Pagination{
        return new AmaticPagination();
    }

    public function getItalicPagination():Pagination{
//        return new
    }
}
