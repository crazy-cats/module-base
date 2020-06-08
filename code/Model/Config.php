<?php


namespace CrazyCat\Base\Model;

class Config extends \CrazyCat\Framework\App\Config
{
    const CACHE_NAME = 'config';
    const SCOPE_STAGE = 'stage';

    /**
     * @var \CrazyCat\Framework\App\Cache\AbstractCache
     */
    protected $cache;

    /**
     * @var \CrazyCat\Framework\App\ObjectManager
     */
    protected $objectManager;

    public function __construct(
        \CrazyCat\Framework\App\ObjectManager $objectManager
    ) {
        parent::__construct();

        $this->objectManager = $objectManager;
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
     * @param string|null $scope global, stage
     * @param string|null $stageId
     * @return Config
     * @throws \ReflectionException
     */
    protected function collectConfigData($scope = self::SCOPE_GLOBAL, $stageId = null)
    {
        if ($this->cache === null) {
            $cacheManager = $this->objectManager->get(\CrazyCat\Framework\App\Cache\Manager::class);
            $this->cache = $cacheManager->create(self::CACHE_NAME);
        }

        $key = $scope . ($stageId === null ? '' : ('-' . $stageId));
        if (!$this->cache->hasData($key)) {
            /* @var $dbManager \CrazyCat\Framework\App\Db\Manager */
            $dbManager = $this->objectManager->get(\CrazyCat\Framework\App\Db\Manager::class);
            $conn = $dbManager->getConnection();
            $sql = sprintf(
                'SELECT `path`, `value` FROM %s WHERE `scope` = ? AND `stage_id` = ?',
                $conn->getTableName('config')
            );
            $this->cache->setData($key, $conn->fetchPairs($sql, [$scope, $stageId]))->save();
        }

        return $this;
    }

    /**
     * @param string      $path
     * @param string|null $scope global, stage
     * @param string|null $stageId
     * @return mixed
     * @throws \Exception
     */
    public function getValue($path)
    {
        list(, $scope, $stageId) = array_pad(func_get_args(), 3, null);

        $globalConfig = $this->getData(self::SCOPE_GLOBAL);
        if ($scope === null || $scope == self::SCOPE_GLOBAL) {
            return $globalConfig[$path] ?? null;
        }

        if (!in_array($scope, [self::SCOPE_WEBSITE, self::SCOPE_STAGE])
            || $stageId === null
        ) {
            throw new \Exception('Invalid parameter.');
        }

        $this->collectConfigData($scope, $stageId);
        $config = $this->cache->getData($scope . '-' . $stageId);
        return $config[$path] ?? ($globalConfig[$path] ?? null);
    }

    /**
     * @param array  $configData
     * @param string $scope
     * @param int    $stageId
     * @return $this
     */
    public function saveConfig($configData, $scope, $stageId = null)
    {
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
