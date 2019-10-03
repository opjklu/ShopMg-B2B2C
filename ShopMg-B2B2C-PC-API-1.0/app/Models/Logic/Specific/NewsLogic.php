<?php
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\News;
use App\Models\Entity\DbNews;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;

/**
 * 消息逻辑层
 * @Bean()
 */
class NewsLogic extends AbstractLogic
{

    public function __construct()
    {
        $this->tableName = DbNews::class;
    }

    public function getResult()
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getMapperClassName() :string
     */
    public function getMapperClassName(): string
    {
        return News::class;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::likeSerachArray()
     */
    public function likeSerachArray(): array
    {
        return [
            News::$theme,
            News::$newsInfo
        ];
    }

    /**
     * 查询单条消息逻辑
     */
    public function info(array $data): array
    {}
}
