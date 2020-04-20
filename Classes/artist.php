<?php


namespace moritzsattl\artist;


class artist
{
private $PK_ARTIST;
private $NAME;
private $PICTURE;
private $BIRTHDATE;
private $DEATHDATE;
private $BIOGRAPHY;
private $FK_PK_EPOCH;

    /**
     * artist constructor.
     * @param $PK_ARTIST
     * @param $NAME
     * @param $PICTURE
     * @param $BIRTHDATE
     * @param $DEATHDATE
     * @param $BIOGRAPHY
     * @param $FK_PK_EPOCH
     */
    public function __construct($PK_ARTIST, $NAME, $PICTURE, $BIRTHDATE, $DEATHDATE, $BIOGRAPHY, $FK_PK_EPOCH)
    {
        $this->PK_ARTIST = $PK_ARTIST;
        $this->NAME = $NAME;
        $this->PICTURE = $PICTURE;
        $this->BIRTHDATE = $BIRTHDATE;
        $this->DEATHDATE = $DEATHDATE;
        $this->BIOGRAPHY = $BIOGRAPHY;
        $this->FK_PK_EPOCH = $FK_PK_EPOCH;
    }

    /**
     * @return mixed
     */
    public function getPKARTIST()
    {
        return $this->PK_ARTIST;
    }

    /**
     * @return mixed
     */
    public function getNAME()
    {
        return $this->NAME;
    }

    /**
     * @return mixed
     */
    public function getPICTURE()
    {
        return $this->PICTURE;
    }

    /**
     * @return mixed
     */
    public function getBIRTHDATE()
    {
        return $this->BIRTHDATE;
    }

    /**
     * @return mixed
     */
    public function getDEATHDATE()
    {
        return $this->DEATHDATE;
    }

    /**
     * @return mixed
     */
    public function getBIOGRAPHY()
    {
        return $this->BIOGRAPHY;
    }

    /**
     * @return mixed
     */
    public function getFKPKEPOCH()
    {
        return $this->FK_PK_EPOCH;
    }



}