<?php
namespace application\libs\pagination;
use \application\libs\pagination\AdminNewsPaginationMaker;
use \application\libs\pagination\AmaticPaginationMaker;

abstract class PaginationMaker {

    abstract public function getPagination():Pagination;

    public function makePagination($id, $numberOfNews,  $numberOfNewsPerPage): string {
        $pagination = $this->getPagination();
        return $pagination->getPages($id, $numberOfNews,  $numberOfNewsPerPage);
    }
}