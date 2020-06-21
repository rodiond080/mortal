<?php
namespace application\libs\pagination;
use application\libs\pagination\Pagination;

class AdminGigsPagination implements Pagination{
    public function getPages($id, $numberOfNews, $numberOfNewsPerPage){
        $numOfPages = ceil($numberOfNews / $numberOfNewsPerPage);
        switch ($numOfPages) {
            case 0:
                return '';
                break;
            case 1:
                return '';
                break;
            default:
                $result = '';
                if ($id == 1) {
                    $result .= '<a href="#" class="pagination arial" onclick="this.preventDefault();">' . '<<' . ' </a>';
                    $result .= '<a href="#" class="pagination arial" onclick="this.preventDefault();">' . '<' . ' </a>';
                } else {
                    $result .= '<a href="/admin/gigs/index/1" class="pagination arial">' . '<<' . ' </a>';
                    $result .= '<a href="/admin/gigs/index/' . ($id - 1) . '" class="pagination arial">' . '<' . ' </a>';
                }

                for ($i = 0; $i < $numOfPages; $i++) {
                    if ($id == ($i + 1)) {
                        $result .= '<a href="/admin/gigs/index/' . ($i + 1) . '" class="pagination arial"><b>' . strval($i + 1) . ' </b></a>';
                    } else {
                        $result .= '<a href="/admin/gigs/index/' . ($i + 1) . '" class="pagination arial">' . strval($i + 1) . ' </a>';
                    }
                }

                if ($id == $numOfPages) {
                    $result .= '<a href="#" class="pagination arial" onclick="this.preventDefault();">' . '>' . ' </a>';
                    $result .= '<a href="#" class="pagination arial" onclick="this.preventDefault();">' . '>>' . ' </a>';
                } else {
                    $result .= '<a href="/admin/gigs/index/' . ($id + 1) . '" class="pagination arial">' . '>' . ' </a>';
                    $result .= '<a href="/admin/gigs/index/' . ($numOfPages) . '" class="pagination arial">' . '>>' . ' </a>';
                }
                return $result;
        }
    }
}
