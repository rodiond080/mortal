<?php
namespace application\models\admin;
use application\database_models\AdminGigsDataBaseModel;
use application\main\Model;
use PDO;

class AdminGigsModel extends Model{

    public function getGigs(){
        $rowOfGigs = $this->db->makeQuery("SELECT * FROM gigs","");
        return $rowOfGigs;
    }

    public function getGigWithId($id){
        $gigDBModel = new AdminGigsDataBaseModel();
        $gigDBModel->find($id);
        return [
            'gigs_id'=>$gigDBModel->getId(),
            'gigs_date'=>$gigDBModel->getDate(),
            'gigs_country'=>$gigDBModel->getCountry(),
            'gigs_city'=>$gigDBModel->getCity(),
            'gigs_address'=>$gigDBModel->getAddress(),
            'gigs_description'=>$gigDBModel->getDescription(),
            'gigs_image'=>$gigDBModel->getPoster()
        ];
    }

    public function getGigsForPage($localId, $numberOfNews, $numberOfNewsPerPage){
        $pdo = new PDO('mysql:host=localhost;dbname=mortaldb', 'mvctest', 'mvctest');
        $st=$pdo->prepare("SELECT * FROM gigs ORDER BY gigs_date DESC LIMIT :start, :step");
        $st->bindValue(':start', ($localId-1)*$numberOfNewsPerPage, PDO::PARAM_INT);
        $st->bindValue(':step', $numberOfNewsPerPage, PDO::PARAM_INT);
        $st->execute();
        $result=$st->fetchAll(PDO::FETCH_ASSOC);
//        debug($result);


//        $result=$this->db->makeQuery("SELECT * FROM gigs ORDER BY gigs_date DESC LIMIT :start, :step", [
//            'start'=>($localId-1)*$numberOfNewsPerPage,
//            'step'=>$numberOfNewsPerPage
//            ]);



        return $result;
    }

    public function deleteOneGig($id){
        $oneNewsObject = new AdminGigsDataBaseModel();
        $oneNewsObject->find($id);
        $oneNewsObject->delete();
        $oneNewsObject->save();
    }

    public function countNumberOfGigs(){
        return $this->db->makeQuery('SELECT COUNT(*) AS number_of_gigs FROM gigs')[0]['number_of_gigs'];
    }

    public function updateGig($post, $files){
        $id = $post['id'];
        $gigDBModel = new AdminGigsDataBaseModel();
        $gigDBModel->find($post['id']);
        $date=$post['date'];
        $oldDate=$gigDBModel->getDate();
        $oldPoster=$gigDBModel->getPoster();
        $country=$post['country'];
        $city=$post['city'];
        $address=$post['address'];
        $description= $post['description'];

        $gigDBModel->setDate($date);
        $gigDBModel->setCountry($country);
        $gigDBModel->setCity($city);
        $gigDBModel->setAddress($address);
        $gigDBModel->setDescription($description);

        if(isset($files['poster'])){
            $dir = 'public/images/gigs/gigs' . substr($oldDate, 0, 10).'id'.$id;
            if (is_dir($dir) === false) {
                mkdir($dir);
                chmod($dir, 0777);
            }else{
                chmod($dir, 0777);
                if($oldPoster!=$files['poster']['name']) {
                    unlink($dir . '/' . $oldPoster);
                }
            }

            $newName = time() . $files['poster']['name'];
            $pathForFiles = $dir . '/' . $newName;
            $pathInSever = $files['poster']['tmp_name'];
            move_uploaded_file($pathInSever, $pathForFiles);
            $gigDBModel->setPoster($newName);

            if($oldDate!=$date){
                $newDirName = 'public/images/gigs/gigs' . substr($date, 0, 10).'id'.$id;
                rename($dir, $newDirName);
            }
        }else{
            if ($post['poster_label']=='Upload files') {
                $dir = 'public/images/gigs/gigs' . substr($oldDate, 0, 10) . 'id' . $id;
                $gigDBModel->setPoster(NULL);
                unlink($dir . '/' . $oldPoster);
            }
        }

        $linksArray = array();
        if(isset($post['links'])){
        $counter = 0;
        foreach (json_decode($post['links']) as $key=>$val){
             $linksArray[$counter]=$val;
             $counter++;
         }
        }
        $gigDBModel->setLinks($linksArray);

        return($gigDBModel->save());

    }

    public function getGigPoster($post){
        $id=$post['id'];
        $gigDBModel = new AdminGigsDataBaseModel();
        $gigDBModel->find($id);
        return $gigDBModel->getPoster();
    }

}