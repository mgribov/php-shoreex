<?php

namespace ShoreEx\Endpoint;

class Itinerary extends Endpoint {

    protected $path = 'itinerary';


    /**
     * @param integer $id
     * @param \DateTime $from - optional
     * @param \DateTime $to - optional
     * @return array
     */
    public function getProducts($shipid, \DateTime $arrival, $duration) {
        $params = [
            'shipid' => $shipid,
            'arrival' => $arrival->format('Y-m-d'),
            'duration' => $duration,
        ];

        return $this->getAll($params, 'products');
    }


}
