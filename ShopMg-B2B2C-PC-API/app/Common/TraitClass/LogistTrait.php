<?php

namespace App\Common\TraitClass;

use Express\KdApiSearch;

trait LogistTrait
{

    /**
     *
     * @param array $post
     */
    private function logistQuery(array $post): array
    {
        $ret = $this->logic->getExpressDataCache($post, 'exp_id');

        if (0 === count($ret)) {
            return [
                '{}',
                ''
            ];
        }

        $logicConf = $this->getGroupConfig('Logistics_query');

        $logistData = [
            'OrderCode' => $post['id'],
            'ShipperCode' => $ret['code'],
            'LogisticCode' => $post['express_id']
        ];

        $logist = new KdApiSearch($logicConf['business_id'], $logicConf['app_key'], $logistData);

        $result = $logist->getOrderTracesByJson();

        return [
            $result,
            $ret
        ];
    }
}