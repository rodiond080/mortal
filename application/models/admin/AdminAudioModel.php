<?php
namespace application\models\admin;
use application\main\Model;

class AdminAudioModel extends Model{

    public function getAllAudioAlbums(){
        return $this->db->makeQuery("SELECT * FROM audio_albums");
    }

    public function getListOfFileNames($id){
        return $this->db->makeQuery("SELECT mp3_name FROM audio_albums_files WHERE audio_albums_id=:audio_albums_id",
            ['audio_albums_id' => $id]
        );
    }


    public function checkIfAlbumExists($name){
        $rowOfAlbums= $this->getAudioAlbumViaName($name);
        foreach ($rowOfAlbums as $albums){
            if($name==$albums['audio_albums_name']){
                return true;
            }
        }
        return false;
    }

    public function checkIfAlbumExistsWithoutAlbumWithId($name, $id){
        $rowOfAlbums= $this->getAudioAlbumViaName($name);
        foreach ($rowOfAlbums as $albums){
            if($name==$albums['audio_albums_name'] && $id!=$albums['audio_albums_id']){
                return true;
            }
        }
        return false;
    }

    public function getAudioAlbumViaName($name){
        return $this->db->makeQuery(
            "SELECT * FROM audio_albums WHERE audio_albums_name=:audio_albums_name",
            ['audio_albums_name' => $name]);
    }

    public function createNewAlbum($name){
        $dir = 'public/audio/'.$name;
        if(is_dir($dir)===false){
            mkdir($dir);
        }
        $this->db->makeQuery("INSERT INTO audio_albums (audio_albums_name) VALUES (:audio_albums_name)",
            [
                'audio_albums_name'=>$name
            ]
        );
    }

    public function getIdViaName($name){
       return $this->db->makeQuery(
            "SELECT audio_albums_id FROM audio_albums WHERE audio_albums_name=:audio_albums_name",
            [
                'audio_albums_name'=>$name
            ]
        )[0]['audio_albums_id'];
    }

    public function getNameViaId($id){
        return $this->db->makeQuery("SELECT audio_albums_name FROM audio_albums WHERE audio_albums_id=:audio_albums_id",
            [
                'audio_albums_id'=>$id
            ]
        )[0]['audio_albums_name'];
    }

    public function getPosterViaId($id){
        return $this->db->makeQuery("SELECT audio_albums_poster FROM audio_albums WHERE audio_albums_id=:audio_albums_id",
            [
                'audio_albums_id'=>$id
            ]
        )[0]['audio_albums_poster'];
    }

    public function uploadFiles($id, $files){
        if(isset($files['audioalbum_track0'])) {
            $formerPoster = $this->getPosterViaId($id);
            $dir = 'public/audio/' . $this->getNameViaId($id);
            for ($i = 0; $i < sizeof($files); $i++) {
                $nameOfIndex = 'audioalbum_track' . $i;
                $newName = time() . $files[$nameOfIndex]['name'];
                $pathForFiles = $dir . '/' . $newName;
                $pathInSever = $files[$nameOfIndex]['tmp_name'];
                move_uploaded_file($pathInSever, $pathForFiles);

                $this->db->makeQuery(
                    "INSERT INTO audio_albums_files (audio_albums_id, mp3_name) VALUES (:audio_albums_id,:mp3_name)",
                    [
                        'audio_albums_id' => $id,
                        'mp3_name' => $newName
                    ]
                );
            }
        }
    }

    public function saveAlbum($id,$name,$post, $files){
        $formerName = $this->getNameViaId($id);
        $formerPosterName = $this->getPosterViaId($id);
        $dir = 'public/images/audio/'.$formerName;
        if(isset($files['audioalbum_poster'])){

            $this->db->makeQuery(
                "UPDATE audio_albums SET audio_albums_poster=:audio_albums_poster
                    WHERE audio_albums_id=:audio_albums_id",
                [
                    'audio_albums_poster'=>$files['audioalbum_poster']['name'],
                    'audio_albums_id'=>$id
                ]
            );
            if (!is_dir($dir)){
                mkdir($dir);
            }else{
                unlink($dir.'/'.$formerPosterName.'/'.$formerPosterName);//TODO remove
            }
            $pathInSever = $files['audioalbum_poster']['tmp_name'];
            move_uploaded_file($pathInSever,$dir.'/'.$files['audioalbum_poster']['name']);

//        }
//        if($formerName!=$name){
//            $this->db->makeQuery(
//                "UPDATE audio_albums SET audio_albums_name=:audio_albums_name
//                    WHERE audio_albums_id=:audio_albums_id",
//                [
//                    'audio_albums_name'=>$name,
//                    'audio_albums_id'=>$id
//                ]
//            );
        }else if($post['audioalbum_poster']=='delete'){
            $this->db->makeQuery(
                "UPDATE audio_albums SET audio_albums_poster=:audio_albums_poster
                    WHERE audio_albums_id=:audio_albums_id",
                [
                    'audio_albums_poster'=>null,
                    'audio_albums_id'=>$id
                ]
            );

            unlink($dir.'/'.$formerPosterName);
            rmdir($dir);//TODO !remove directory!
        }
        if($name!=$formerName){
            rename('public/images/audio/'.$formerName, 'public/images/audio/'.$name);
            rename('public/audio/'.$formerName, 'public/audio/'.$name);
            $this->db->makeQuery("UPDATE audio_albums SET 
                audio_albums_name=:audio_albums_name WHERE audio_albums_id=:audio_albums_id",
                [
                    'audio_albums_id'=>$id,
                    'audio_albums_name'=>$name
                ]
            );
        }

    }

    public function deleteFiles($id, $allFileNames){
        $dir = 'public/audio/'.$this->getNameViaId($id);
        $rowOfFormerFiles = $this->db->makeQuery("SELECT * FROM audio_albums_files WHERE audio_albums_id=:audio_albums_id",
            [
                'audio_albums_id'=>$id
            ]
        );

        foreach ($rowOfFormerFiles as $file){
            if (!in_array($file['mp3_name'], $allFileNames)){
                $this->db->makeQuery("DELETE FROM audio_albums_files WHERE mp3_name=:mp3_name",
                    [
                        'mp3_name'=>$file['mp3_name']
                    ]
                );
                unlink($dir.'/'.$file['mp3_name']);
            }
        }
    }



}