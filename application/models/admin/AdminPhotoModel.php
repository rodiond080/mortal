<?php
namespace application\models\admin;
use application\main\Model;

class AdminPhotoModel extends Model
{

    public function getAllPhotoAlbums()
    {
        return $this->db->makeQuery("SELECT * FROM photo_albums");
    }

    public function getAlbumNameViaId($id)
    {
        return $this->db->makeQuery(
            "SELECT photo_albums_name FROM photo_albums WHERE photo_albums_id=:photo_albums_id",
            ['photo_albums_id' => $id]
        )[0]['photo_albums_name'];
    }

    public function getListOfImages($id)
    {
        return $this->db->makeQuery("SELECT img_name, is_cover FROM photo_albums_images WHERE photo_albums_id=:photo_albums_id",
            ['photo_albums_id' => $id]
        );
    }

    public function checkIfAlbumExists($name)
    {
        $rowOfAlbums = $this->getPhotoAlbumViaName($name);
        foreach ($rowOfAlbums as $albums) {
            if ($name == $albums['photo_albums_name']) {
                return true;
            }
        }
        return false;
    }

    public function checkIfAlbumExistsWithoutAlbumWithId($name, $id)
    {
        $rowOfAlbums = $this->getPhotoAlbumViaName($name);
        foreach ($rowOfAlbums as $albums) {
            if ($name == $albums['photo_albums_name'] && $id != $albums['photo_albums_id']) {
                return true;
            }
        }
        return false;
    }

    public function getPhotoAlbumViaName($name)
    {
        return $this->db->makeQuery(
            "SELECT * FROM photo_albums WHERE photo_albums_name=:photo_albums_name",
            ['photo_albums_name' => $name]);
    }

    public function createNewAlbum($name)
    {
        $dir = 'public/images/photo/' . $name;
        if (is_dir($dir) === false) {
            mkdir($dir);
        }
        $this->db->makeQuery("INSERT INTO photo_albums (photo_albums_name) VALUES (:photo_albums_name)",
            [
                'photo_albums_name' => $name
            ]
        );
    }

    public function getIdViaName($name)
    {
        return $this->db->makeQuery(
            "SELECT photo_albums_id FROM photo_albums WHERE photo_albums_name=:photo_albums_name",
            [
                'photo_albums_name' => $name
            ]
        )[0]['photo_albums_id'];
    }

    public function getNameViaId($id)
    {
        return $this->db->makeQuery("SELECT photo_albums_name FROM photo_albums WHERE photo_albums_id=:photo_albums_id",
            [
                'photo_albums_id' => $id
            ]
        )[0]['photo_albums_name'];
    }

    public function uploadFiles($id, $files, $nameOfCheckedRadio)
    {
        $dir = 'public/images/photo/' . $this->getNameViaId($id);
        for ($i = 0; $i < sizeof($files); $i++) {
            $nameOfIndex = 'photo' . $i;
            $newName = time() . $files[$nameOfIndex]['name'];
            $pathForFiles = $dir . '/' . $newName;
            $pathInSever = $files[$nameOfIndex]['tmp_name'];
            $isCover=($files[$nameOfIndex]['name']===$nameOfCheckedRadio)?1:0;
            move_uploaded_file($pathInSever, $pathForFiles);

            $this->db->makeQuery(
                "INSERT INTO photo_albums_images (photo_albums_id, img_name, is_cover) VALUES (:photo_albums_id,:img_name, :is_cover)",
                [
                    'photo_albums_id' => $id,
                    'img_name' => $newName,
                    'is_cover'=>$isCover
                ]
            );

        }
    }

    public function updateFiles($id, $nameOfCheckedRadio){
        $rowOfImages= $this->getListOfImages($id);
        foreach ($rowOfImages as $image){
            if($image['is_cover']==1 && $image['img_name']!=$nameOfCheckedRadio){
                $this->db->makeQuery("UPDATE photo_albums_images SET is_cover=0 
                WHERE img_name=:img_name", ['img_name'=>$image['img_name']]);
            }

            if($image['img_name']==$nameOfCheckedRadio){
                $this->db->makeQuery("UPDATE photo_albums_images SET is_cover=1 
                WHERE img_name=:img_name", ['img_name'=>$nameOfCheckedRadio]);
            }
        }
    }

    public function deleteFiles($id, $allFileNames)
    {
        $dir = 'public/images/photo/' . $this->getNameViaId($id);
        $rowOfFormerFiles = $this->db->makeQuery("SELECT * FROM photo_albums_images WHERE photo_albums_id=:photo_albums_id",
            [
                'photo_albums_id' => $id
            ]
        );

        foreach ($rowOfFormerFiles as $file) {
            if (!in_array($file['img_name'], $allFileNames)) {
                $this->db->makeQuery("DELETE FROM photo_albums_images WHERE img_name=:img_name",
                    [
                        'img_name' => $file['img_name']
                    ]
                );
                unlink($dir . '/' . $file['img_name']);
            }
        }
    }

}