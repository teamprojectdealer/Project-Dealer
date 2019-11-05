<?php

class Project
{
    private $id;
    private $name;
    private $filePath;
    private $userId;
    private $priceInPound;
    private $description;
    private $projectImage;
    
    //setters
    public function setId($id){
        $this->id = $id;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function setFilePath($filePath){
        $this->filePath = $filePath;
    }
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setPrice($priceInPound){
        $this->priceInPound = $priceInPound;
    }
    public function setDescription($description){
        $this->description = $description;
    }
    public function setProjectImage($projectImage){
        $this->projectImage = $projectImage;
    }

    //getters
    public function getId(){
		return $this->id;
	}
    public function getName(){
        return $this->name;
    }
    public function getFilePath(){
        return $this->filePath;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getPrice(){
        return $this->priceInPound;
    }
    public function getDescription(){
        return $this->description;
    }
    public function getProjectImage(){
        return $this->projectImage;
    }

}


?>