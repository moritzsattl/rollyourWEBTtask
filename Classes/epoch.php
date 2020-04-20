<?php


namespace moritzsattl\epoch;


class epoch
{
private $PK_EPOCH;
private $NAME;
private $FROM;
private $TO;
private $DESCRIPTION;

    /**
     * epoch constructor.
     * @param $PK_EPOCH
     * @param $NAME
     * @param $FROM
     * @param $TO
     * @param $DESCRIPTION
     */
    public function __construct($PK_EPOCH, $NAME, $FROM, $TO, $DESCRIPTION)
    {
        $this->PK_EPOCH = $PK_EPOCH;
        $this->NAME = $NAME;
        $this->FROM = $FROM;
        $this->TO = $TO;
        $this->DESCRIPTION = $DESCRIPTION;
    }

    /**
     * @return mixed
     */
    public function getPKEPOCH()
    {
        return $this->PK_EPOCH;
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
    public function getFROM()
    {
        return $this->FROM;
    }

    /**
     * @return mixed
     */
    public function getTO()
    {
        return $this->TO;
    }

    /**
     * @return mixed
     */
    public function getDESCRIPTION()
    {
        return $this->DESCRIPTION;
    }



}