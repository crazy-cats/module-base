<?php


namespace CrazyCat\Base\Framework;

class Config
{
    public const CACHE_NAME = 'config';

    public const SCOPE_GLOBAL = 'global';
    public const SCOPE_STAGE = 'stage';

    /**
     * @var \CrazyCat\Framework\App\Cache\AbstractCache
     */
    protected $cache;

    /**
     * @var \CrazyCat\Framework\App\Db\MySql
     */
    protected $conn;

    /**
     * @var string
     */
    protected $mainTable = 'config';

    public function __construct(
        \CrazyCat\Framework\App\Cache\Manager $cacheManager,
        \CrazyCat\Framework\App\Db\Manager $dbManager
    ) {
        $this->cache = $cacheManager->create(self::CACHE_NAME);
        $this->conn = $dbManager->getConnection();
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function encodeValue($value)
    {
        return json_encode($value);
    }

    /**
     * @param string $value
     * @return mixed
     */
    protected function decodeValue($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param string $scope
     * @param int    $stageId
     * @return string
     */
    protected function getCacheKey($scope, $stageId)
    {
        return $scope . ($stageId === null ? '' : ('-' . $stageId));
    }

    /**
     * @param string $path
     * @param string $scope
     * @param int    $stageId
     * @return mixed
     * @throws \Exception
     */
    public function getValue($path, $scope = self::SCOPE_GLOBAL, $stageId = 0)
    {
        $cacheKey = $this->getCacheKey($scope, $stageId);
        if (!$this->cache->hasData($cacheKey)) {
            if ($stageId === null) {
                $sql = sprintf(
                    'SELECT `path`, `value` FROM %s WHERE `scope` = ?',
                    $this->conn->getTableName('config')
                );
                $data = $this->conn->fetchPairs($sql, [$scope]);
            } else {
                $sql = sprintf(
                    'SELECT `path`, `value` FROM %s WHERE `scope` = ? AND `stage_id` = ?',
                    $this->conn->getTableName('config')
                );
                $data = $this->conn->fetchPairs($sql, [$scope, $stageId]);
            }
            foreach ($data as $path => $value) {
                $data[$path] = $this->decodeValue($value);
            }
            $this->cache->setData($cacheKey, $data)->save();
        }
        return $this->cache->getData($cacheKey)[$path] ?? null;
    }

    /**
     * @param array  $configData
     * @param string $scope
     * @param int    $stageId
     * @return $this
     * @throws \Exception
     */
    public function saveConfig($configData, $scope, $stageId = 0)
    {
        $this->cache->setData($this->getCacheKey($scope, $stageId), $configData)->save();

        $data = [];
        foreach ($configData as $path => $value) {
            $data[] = [
                'scope'    => $scope,
                'stage_id' => $stageId,
                'path'     => $path,
                'value'    => $this->encodeValue($value)
            ];
        }
        $this->conn->insertUpdate($this->conn->getTableName($this->mainTable), $data, ['path', 'value']);

        return $this;
    }
}
