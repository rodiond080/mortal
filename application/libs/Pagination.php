<?php
namespace application\libs;

class Pagination{
    private $id;
    private $numberOfNews;
    private $numberOfNewsPerPage;

    public function __construct($id, $numberOfNews,  $numberOfNewsPerPage){
        $this->id=$id;
        $this->numberOfNews=$numberOfNews;
        $this->numberOfNewsPerPage=$numberOfNewsPerPage;
    }

    public function get(){
        $numOfPages = ceil($this->numberOfNews / $this->numberOfNewsPerPage);
        switch ($numOfPages) {
            case 0:
                return '';
                break;
            case 1:
                return '';
                break;
            default:
                $result = '';
                if ($this->id == 1) {
                    $result .= '<a href="#" style="text-decoration: none; color: white" onclick="this.preventDefault();">' . '<<' . ' </a>';
                    $result .= '<a href="#" style="text-decoration: none; color: white" onclick="this.preventDefault();">' . '<' . ' </a>';
                } else {
                    $result .= '<a href="/news/index/1" style="text-decoration: none; color: white">' . '<<' . ' </a>';
                    $result .= '<a href="/news/index/' . ($this->id - 1) . '" style="text-decoration: none; color: white">' . '<' . ' </a>';
                }

                for ($i = 0; $i < $numOfPages; $i++) {
                    if ($this->id == ($i + 1)) {
                        $result .= '<a href="/news/index/' . ($i + 1) . '" style="text-decoration: none; color: white"><b>' . strval($i + 1) . ' </b></a>';
                    } else {
                        $result .= '<a href="/news/index/' . ($i + 1) . '" style="text-decoration: none; color: white">' . strval($i + 1) . ' </a>';
                    }
                }

                if ($this->id == $numOfPages) {
                    $result .= '<a href="#" style="text-decoration: none; color: white" onclick="this.preventDefault();">' . '>' . ' </a>';
                    $result .= '<a href="#" style="text-decoration: none; color: white" onclick="this.preventDefault();">' . '>>' . ' </a>';
                } else {
                    $result .= '<a href="/news/index/' . ($this->id + 1) . '" style="text-decoration: none; color: white">' . '>' . ' </a>';
                    $result .= '<a href="/news/index/' . ($numOfPages) . '" style="text-decoration: none; color: white">' . '>>' . ' </a>';
                }
                return $result;
        }
    }
}