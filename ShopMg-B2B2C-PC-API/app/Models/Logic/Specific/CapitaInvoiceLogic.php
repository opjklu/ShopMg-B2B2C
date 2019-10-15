<?php
declare(strict_types=1);

namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\CapitaInvoice;
use App\Models\Entity\DbCapitaInvoice;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 增值税
 * @Bean()
 *
 * @author wq
 */
class CapitaInvoiceLogic extends AbstractLogic
{


    public function __construct()
    {
        $this->tableName = DbCapitaInvoice::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getResult()
     */
    public function getResult()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName()
     */
    public function getMapperClassName(): string
    {
        return CapitaInvoice::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getTableColum()
     */
    protected function getTableColum(): array
    {
        return [
            'id',
            'company_name',
            'opening_bank',
            'prov_id',
            'city_id',
            'dist_id',
            'register_address',
            'register_tel',
            'opening_bank',
            'ein',
            'bank_account'
        ];
    }

    /**
     * 获取条件根据单条
     *
     * @return array
     */
    protected function getWhereByFindOne(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    /**
     * 多条数据获取地区id
     *
     * @param array $data
     * @return array
     */
    public function parseAreaWhere(array $data): array
    {
        return array_merge(array_column($data, CapitaInvoice::$provId), array_column($data, CapitaInvoice::$cityId), array_column($data, CapitaInvoice::$distId));
    }

    /**
     * 单条获取地区id条件
     *
     * @param array $data
     * @return array
     */
    public function parseAreaWhereOne(array $data): array
    {
        return [
            $data[CapitaInvoice::$provId],
            $data[CapitaInvoice::$cityId],
            $data[CapitaInvoice::$distId]
        ];
    }

    /**
     * 处理条件
     *
     * @return array
     */
    protected function parseOption(array $options): array
    {
        $options['where']['user_id'] = session()->get('user_id');
        return $options;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        $time = time();

        $insert['create_time'] = $time;

        $insert['update_time'] = $time;

        $insert['user_id'] = session()->get('user_id');

        return $insert;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultBySave(array $update = []): array
    {
        $update['update_time'] = time();

        return $update;
    }

    /**
     * 保存时条件处理
     *
     * @param array $post
     * @return array
     */
    protected function getWhereBySaveAndDelete(): array
    {
        return [
            'user_id' => session()->get('user_id')
        ];
    }

    // 我的发票--删除增值发票
    public function getCapitaDelete()
    {
        $res = parent::delete();
        if (!$res) {
            return array(
                "status" => 0,
                "message" => "删除失败",
                "data" => ''
            );
        }
        return array(
            "status" => 1,
            "message" => "删除成功",
            "data" => ''
        );
    }

    public function getValidateByAddCapita(): array
    {
        return [
            'company_name' => [
                'required' => '公司名称必须'
            ],
            'ein' => [
                'required' => '税号必须'
            ],
            'opening_bank' => [
                'required' => '开户行必须',
                'checkChineseAndEnglish' => '必须是中文或者英文'
            ],
            'bank_account' => [
                'required' => '开户账号必须'
            ],
            'prov_id' => [
                'number' => '省份必须'
            ],
            'city_id' => [
                'number' => '市区必须'
            ],
            'dist_id' => [
                'number' => '地区必须'
            ],
            'register_address' => [
                'required' => '注册地址必须',
                'checkChineseAndEnglish' => '必须是中文或者英文'
            ],
            'register_tel' => [
                'required' => '注册电话必须'
            ]
        ];
    }

    public function getValidateByEditCapita(): array
    {
        $message = $this->getValidateByAddCapita();

        $message['id'] = [
            'number' => 'id 必须是数字'
        ];

        return $message;
    }
}