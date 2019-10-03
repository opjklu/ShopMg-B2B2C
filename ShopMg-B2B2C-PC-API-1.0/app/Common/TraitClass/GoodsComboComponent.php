<?php
declare(strict_types=1);

namespace App\Common\TraitClass;

trait GoodsComboComponent
{

    /**
     * 得到互补商品
     */
    public function getComplementaryCommodities(array $post): array
    {
        $subIds = $this->getQueryBuilderProxy()
            ->field([
                'sub_ids'
            ])
            ->where('goods_id', $post['goods_id'])
            ->select();

        if (0 === count($subIds)) {
            $this->errorMessage = '暂无产品';
            return [];
        }

        $real = [];

        foreach ($subIds as $value) {
            $real = array_merge($real, explode(',', $value['sub_ids']));
        }
        return $real;
    }
}