<?php


namespace CrazyCat\Base\Framework;

use CrazyCat\Base\Model\Stage\Manager as StageManager;
use CrazyCat\Framework\App\Config as AppConfig;

class Config
{
    public const CACHE_NAME = 'scope_config';
    public const CACHE_SETTINGS_NAME = 'scope_config_settings';

    public const CONFIG_FILE = 'settings.php';

    public const SCOPE_GLOBAL = 'global';
    public const SCOPE_STAGE = 'stage';

    /**
     * @var \CrazyCat\Framework\App\Cache\AbstractCache
     */
    protected $cache;

    /**
     * @var \CrazyCat\Framework\App\Cache\AbstractCache
     */
    protected $settingsCache;

    /**
     * @var \CrazyCat\Framework\App\Db\MySql
     */
    protected $conn;

    /**
     * @var \CrazyCat\Framework\App\Component\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var string
     */
    protected $mainTable = 'config';

    public function __construct(
        \CrazyCat\Framework\App\Cache\Manager $cacheManager,
        \CrazyCat\Framework\App\Component\Module\Manager $moduleManager,
        \CrazyCat\Framework\App\Db\Manager $dbManager
    ) {
        $this->moduleManager = $moduleManager;

        $this->conn = $dbManager->getConnection();

        $this->cache = $cacheManager->create(self::CACHE_NAME);
        $this->settingsCache = $cacheManager->create(self::CACHE_SETTINGS_NAME);
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
     * @return void
     */
    public function getSettings()
    {
        if (empty($this->settingsCache->getData())) {
            $settings = [];
            foreach ($this->moduleManager->getEnabledModules() as $module) {
                $configFile = $module->getData('dir') . DS . AppConfig::DIR . DS . self::CONFIG_FILE;
                if (!is_file($configFile)) {
                    continue;
                }
                $moduleSettings = require $configFile;
                foreach ($moduleSettings as $groupName => $settingGroup) {
                    if (!isset($settings[$groupName])) {
                        $settings[$groupName] = [
                            'fields' => []
                        ];
                    }
                    if (isset($settingGroup['label'])) {
                        $settings[$groupName]['label'] = $settingGroup['label'];
                    }
                    if (isset($settingGroup['scopes'])) {
                        $settings[$groupName]['scopes'] = $settingGroup['scopes'];
                    }
                    if (isset($settingGroup['sort_order'])) {
                        $settings[$groupName]['sort_order'] = $settingGroup['sort_order'];
                    }
                    $fields = [];
                    foreach ($settingGroup['fields'] as $fieldName => $field) {
                        $field['name'] = $groupName . '/' . $fieldName;
                        $fields[$fieldName] = $field;
                    }
                    $settings[$groupName]['fields'] = array_merge(
                        $settings[$groupName]['fields'],
                        $fields
                    );
                }
            }
            $this->settingsCache->setData($settings)->save();
        }
        return $this->settingsCache->getData();
    }

    /**
     * @param string $path
     * @param string $scope
     * @param int    $stageId
     * @return mixed
     * @throws \Exception
     */
    public function getValue($path, $scope = self::SCOPE_GLOBAL, $stageId = StageManager::GLOBAL_STAGE_ID)
    {
        $cacheKey = $this->getCacheKey($scope, $stageId);
        if (!$this->cache->hasData($cacheKey)) {
            if ($scope === self::SCOPE_GLOBAL) {
                $sql = sprintf(
                    'SELECT `path`, `value` FROM %s WHERE `scope` = ?',
                    $this->conn->getTableName('config')
                );
                $data = $this->conn->fetchPairs($sql, [$scope]);
            } else {
                $sql = sprintf(
                    'SELECT `path`, `value` FROM %s WHERE `scope` = ? AND `stage_id` = ?',
                    $this->conn->getTableName('config'),
                    $stageId
                );
                $data = $this->conn->fetchPairs($sql, [$scope, $stageId]);
            }
            foreach ($data as $key => $value) {
                $data[$key] = $this->decodeValue($value);
            }
            $this->cache->setData($cacheKey, $data)->save();
        }

        $configData = $this->cache->getData($cacheKey);
        if (!isset($configData[$path])) {
            $configData[$path] = ($scope == self::SCOPE_STAGE)
                ? $this->getValue($path, self::SCOPE_GLOBAL)
                : null;
            if ($configData[$path] === null) {
                $settings = $this->getSettings();
                [$groupName, $fieldName] = explode('/', $path);
                $configData[$path] = $settings[$groupName]['fields'][$fieldName]['default'] ?? null;
            }
        }
        return $configData[$path];
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
