<?php
namespace application\database_models;
use application\main\DataBaseModel;
use application\libs\DB;

class AdminGigsDataBaseModel extends DataBaseModel{
    private $id;
    private $date;
    private $country;
    private $city;
    private $address;
    private $description;
    private $poster;
    private $links;
    private $delete;

    /**
     * AdminGigsDataBaseModel constructor.
     * @param $id
     * @param $date
     * @param $country
     * @param $city
     * @param $address
     * @param $description
     * @param $poster
     */
    public function __construct($id=NULL, $date=NULL, $country=NULL, $city=NULL, $address=NULL, $description=NULL, $poster=NULL){
        $this->id = $id;
        $this->date = $date;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->description = $description;
        $this->poster = $poster;
        $this->links=array();
        $this->delete=false;
    }

    public function find($id){
        $this->id=$id;
        $db = new DB();
        $rowOfGig = $db->makeQuery("SELECT * FROM gigs WHERE gigs_id=:id", ["id"=>$this->id])[0];
        $this->date=$rowOfGig['gigs_date'];
        $this->country=$rowOfGig['gigs_country'];
        $this->city=$rowOfGig['gigs_city'];
        $this->address=$rowOfGig['gigs_address'];
        $this->description=$rowOfGig['gigs_description'];
        $this->poster=$rowOfGig['gigs_image'];
    }

    public function save(){
        $db = new DB();
        if($this->delete){
            $db->makeQuery("DELETE FROM gigs WHERE gigs_id=:gigs_id", ["gigs_id"=>$this->id]);
            $db->makeQuery("DELETE FROM gigs_links WHERE gig_id=:gig_id", ["gig_id"=>$this->id]);
        }else{
            $db->makeQuery("UPDATE gigs SET 
                    gigs_date=:gigs_date, gigs_country=:gigs_country, gigs_city=:gigs_city, gigs_address=:gigs_address, 
                     gigs_description=:gigs_description, gigs_image=:gigs_image WHERE gigs_id=:gigs_id",
                [
                    "gigs_id"=>$this->getId(),
                    "gigs_date"=>$this->getDate(),
                    "gigs_country"=>$this->getCountry(),
                    "gigs_city"=>$this->getCity(),
                    "gigs_address"=>$this->getAddress(),
                    "gigs_description"=>$this->getDescription(),
                    "gigs_image"=>$this->getPoster(),
                ]);


            if(empty($this->getLinks())){
                $db->makeQuery("DELETE FROM gigs_links WHERE gig_id=:gig_id", ["gig_id"=>$this->id]);
            }

            $rowOfFormerGigLinks= $db->makeQuery('SELECT * FROM gigs_links WHERE gig_id=:id', ["id"=>$this->id]);

            if(empty($rowOfFormerGigLinks)){
                foreach ($this->links as $key=>$val){
                    $db->makeQuery('INSERT INTO gigs_links (gig_id, gig_link) VALUES (:gig_id, :gig_link ', ['gig_id' => $this->getId(), 'gig_link' => $val]);
                }
            }else {
                $arrayOfFormerLinks = array();
                $counter = 0;
                foreach ($rowOfFormerGigLinks as $key => $val) {
                    $arrayOfFormerLinks[$counter] = $val['gig_link'];
                    $counter++;
                }


                foreach ($arrayOfFormerLinks as $key => $val) {
                    if (!in_array($val, $this->getLinks())) {
                        $db->makeQuery('DELETE FROM gigs_links WHERE gig_link=:gig_link', ['gig_link' => $val]);
                        unset($val, $arrayOfFormerLinks);
                    }
                }

                foreach ($this->getLinks() as $key => $val) {
                    if (!in_array($val, $arrayOfFormerLinks)) {
                        $db->makeQuery('INSERT INTO gigs_links (gig_id, gig_link) VALUES (:gig_id, :gig_link);', ['gig_id' => $this->getId(), 'gig_link' => $val]);
                    }
                }
            }

        }
    }

    public function delete(){
        $this->delete=true;
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @param array $links
     */
    public function setLinks($links)
    {
        $this->links = $links;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param null $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return null
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param null $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param null $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
    }




}