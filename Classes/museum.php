<?php


namespace moritzsattl\museum;


class museum
{
    private $PK_MUSEUM;
    private $NAME;
    private $LOGO;
    private $POSTALCODE;
    private $PLACE;
    private $STREET;
    private $HOUSENUMBER;
    private $COUNTRY;

    /**
     * museum constructor.
     * @param $PK_MUSEUM
     * @param $NAME
     * @param $LOGO
     * @param $POSTALCODE
     * @param $PLACE
     * @param $STREET
     * @param $HOUSENUMBER
     * @param $COUNTRY
     */
    public function __construct($PK_MUSEUM, $NAME, $LOGO, $POSTALCODE, $PLACE, $STREET, $HOUSENUMBER, $COUNTRY)
    {
        $this->PK_MUSEUM = $PK_MUSEUM;
        $this->NAME = $NAME;
        $this->LOGO = $LOGO;
        $this->POSTALCODE = $POSTALCODE;
        $this->PLACE = $PLACE;
        $this->STREET = $STREET;
        $this->HOUSENUMBER = $HOUSENUMBER;
        $this->COUNTRY = $COUNTRY;
    }

    /**
     * @return mixed
     */
    public function getPKMUSEUM()
    {
        return $this->PK_MUSEUM;
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
    public function getLOGO()
    {
        return $this->LOGO;
    }

    /**
     * @return mixed
     */
    public function getPOSTALCODE()
    {
        return $this->POSTALCODE;
    }

    /**
     * @return mixed
     */
    public function getPLACE()
    {
        return $this->PLACE;
    }

    /**
     * @return mixed
     */
    public function getSTREET()
    {
        return $this->STREET;
    }

    /**
     * @return mixed
     */
    public function getHOUSENUMBER()
    {
        return $this->HOUSENUMBER;
    }

    /**
     * @return mixed
     */
    public function getCOUNTRY()
    {
        return $this->COUNTRY;
    }




}