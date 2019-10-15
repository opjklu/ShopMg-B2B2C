<?php
declare(strict_types = 1);
namespace App\Models\Logic\Specific;

use App\Common\FieldMapping\UserHeader;
use App\Models\Entity\DbUserHeader;
use Swoft\App;
use Swoft\Bean\Annotation\Bean;
use App\Models\Logic\AbstractLogic;
use Tool\CURL;
use Tool\Db;

/**
 * 用户逻辑处理层
 * @Bean()
 */
class UserHeaderLogic extends AbstractLogic
{

    public function __construct()
    {
        $this->tableName = DbUserHeader::class;
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
        return UserHeader::class;
    }

    /**
     * 验证头像
     *
     * @return array
     */
    public function getValidateUserHeader(): array
    {
        return [
            'user_header' => [
                'required' => '头像必须上传'
            ]
        ];
    }

    /**
     * 处理头像
     *
     * @return bool
     */
    public function parseUserHeader(array $post): bool
    {
        Db::beginTransaction();
        
        $userId = session()->get('user_id');
        
        $status = $this->getQueryBuilderProxy()
            ->where(UserHeader::$userId, $userId)
            ->delete();
        
        $post['user_id'] = $userId;
        
        $status = $this->addData($post);
        
        if (! $this->traceStation($status)) {
            return false;
        }
        
        Db::commit();
        
        // 远程删图片
        $curlFile = new CURL([
            'fileName' => $post['user_header']
        ], App::getBean('config')->get('unlink_image_no_thumb'));
        
        $curlFile->asynchronousExecution();
        
        return true;
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \App\Models\Logic\Specific\AbstractLogic::getParseResultByAdd()
     */
    protected function getParseResultByAdd(array $insert): array
    {
        return $insert;
    }
}
