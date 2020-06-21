<?php
namespace application\libs\pagination;
use application\libs\pagination\Pagination;

class AmaticPagination implements Pagination{

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
                    $result .= '<a href="#" class="pagination amatic" onclick="this.preventDefault();">' . '<<' . ' </a>';
                    $result .= '<a href="#" class="pagination amatic" onclick="this.preventDefault();">' . '<' . ' </a>';
                } else {
                    $result .= '<a href="/news/index/1" class="pagination amatic">' . '<<' . ' </a>';
                    $result .= '<a href="/news/index/' . ($id - 1) . '" class="pagination amatic">' . '<' . ' </a>';
                }

                for ($i = 0; $i < $numOfPages; $i++) {
                    if ($id == ($i + 1)) {
                        $result .= '<a href="/news/index/' . ($i + 1) . '" class="pagination amatic"><b>' . strval($i + 1) . ' </b></a>';
                    } else {
                        $result .= '<a href="/news/index/' . ($i + 1) . '" class="pagination amatic">' . strval($i + 1) . ' </a>';
                    }
                }

                if ($id == $numOfPages) {
                    $result .= '<a href="#" class="pagination amatic" onclick="this.preventDefault();">' . '>' . ' </a>';
                    $result .= '<a href="#" class="pagination amatic" onclick="this.preventDefault();">' . '>>' . ' </a>';
                } else {
                    $result .= '<a href="/news/index/' . ($id + 1) . '"class="pagination amatic">' . '>' . ' </a>';
                    $result .= '<a href="/news/index/' . ($numOfPages) . '" class="pagination amatic">' . '>>' . ' </a>';
                }
                return $result;
        }
    }
}


