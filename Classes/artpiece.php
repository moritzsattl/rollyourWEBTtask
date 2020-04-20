<?php
namespace moritzsattl\artpiece;
class artpiece{
    private $PK_ARTPIECE;
    private $NAME;
    private $YEAR;
    private $PICTURE;
    private $DESCRIPTION;
    private $FK_PK_ARTIST;
    private $FK_PK_MUSEUM;

    /**
     * artpieces constructor.
     * @param $PK_ARTPIECE
     * @param $NAME
     * @param $YEAR
     * @param $PICTURE
     * @param $DESCRIPTION
     * @param $FK_PK_ARTIST
     * @param $FK_PK_MUSEUM
     */
    public function __construct($PK_ARTPIECE, $NAME, $YEAR, $PICTURE, $DESCRIPTION, $FK_PK_ARTIST, $FK_PK_MUSEUM)
    {
        $this->PK_ARTPIECE = $PK_ARTPIECE;
        $this->NAME = $NAME;
        $this->YEAR = $YEAR;
        $this->PICTURE = $PICTURE;
        $this->DESCRIPTION = $DESCRIPTION;
        $this->FK_PK_ARTIST = $FK_PK_ARTIST;
        $this->FK_PK_MUSEUM = $FK_PK_MUSEUM;
    }

    /**
     * @return mixed
     */
    public function getPKARTPIECE()
    {
        return $this->PK_ARTPIECE;
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
    public function getYEAR()
    {
        return $this->YEAR;
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
    public function getDESCRIPTION()
    {
        return $this->DESCRIPTION;
    }

    /**
     * @return mixed
     */
    public function getFKPKARTIST()
    {
        return $this->FK_PK_ARTIST;
    }

    /**
     * @return mixed
     */
    public function getFKPKMUSEUM()
    {
        return $this->FK_PK_MUSEUM;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
    }


}
