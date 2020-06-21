<?php
namespace application\libs\pagination;
use application\libs\pagination\AdminNewsPagination;

class AdminGigsPaginationMaker extends PaginationMaker{
    public function getPagination(): Pagination{
        return new AdminGigsPagination();
    }
}