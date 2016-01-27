<?php

namespace ShoreEx\Endpoint;

class Products extends Endpoint {

    protected $path = 'products';
    protected $primaryKey = 'code';


    /**
     * @param string $productcode
     * @param string $shipid - optional
     * @param \DateTime $arrival - optional
     * @param int $duration - optional
     * @return array
     */
    public function getDates($productcode, $shipid = null, \DateTime $arrival = null, $duration = null) {
        $params = [
            'code' => $productcode,
        ];

        if (!is_null($shipid)) {
            $params['shipid'] = $shipid;
        }

        if (!is_null($arrival)) {
            $params['arrival'] = $arrival->format('Y-m-d');
        }

        if (!is_null($duration)) {
            $params['duration'] = $duration;
        }

        return $this->getAll($params, 'dates');
    }


    /**
     * @param string $productcode
     * @param \DateTime $arrival
     * @return array
     */
    public function getTimes($productcode, \DateTime $arrival) {
        $params = [
            'code' => $productcode,
            'date' => $arrival->format('Y-m-d'),
        ];

        return $this->getAll($params, 'times');
    }


}
