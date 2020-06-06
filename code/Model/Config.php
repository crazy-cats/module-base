<?php


namespace CrazyCat\Base\Model;

class Config extends \CrazyCat\Framework\App\Config
{
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
     * @param string|null $scope global, website, stage
     * @param string|null $stageId
     * @return Config
     * @throws \ReflectionException
     */
    protected function collectConfigData($scope, $stageId)
    {
        parent::collectConfigData($scope, $stageId);

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
