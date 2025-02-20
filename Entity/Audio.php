<?php
require_once 'Bdd.php';

Class Audio
{
    private $id;
    private $audioTitle;
    private $description;
    private $idUser;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAudioTitle()
    {
        return $this->audioTitle;
    }

    /**
     * @param mixed $audioTitle
     */
    public function setAudioTitle($audioTitle): void
    {
        $this->audioTitle = $audioTitle;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser): void
    {
        $this->idUser = $idUser;
    }

    public function insertAudio(){
        $bdd = new Bdd();
        $req = $bdd->getConnexion()->prepare("INSERT INTO Audio (audioTitle,description,idUser) VALUES (:audioTitle,:description,:idUser)");
        $req->execute(array(
            "audioTitle" => $this->audioTitle,
            "description" => $this->description,
            "idUser" => $this->idUser
        ));
            }



}
