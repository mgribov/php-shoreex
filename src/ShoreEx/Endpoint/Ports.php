<?php

namespace ShoreEx\Endpoint;

class Ports extends Endpoint {

    protected $path = 'ports';
    protected $primaryKey = 'portCode';


    /**
     * @param integer $id
     * @param \DateTime $from - optional
     * @param \DateTime $to - optional
     * @return array
     */
    public function getProducts($portCode) {
        $params = [
            'port' => $portCode,
        ];

        return $this->getAll($params, 'products');
    }


}
