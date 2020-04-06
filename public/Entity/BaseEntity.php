<?php

namespace App\Entity;

use App\Helpers\Registry;

abstract class BaseEntity
{

    protected $tablePrefix = '';

	const MAPPING_KEY = '';

	protected $data = [];

	public function __construct($values = [], $tablePrefix = '')
	{
		if (empty($values)) {
			return $this;
		}

		$this->data = $values;

		$values = $this->extractMappingValues($values, $tablePrefix);

		foreach ($values as $key => $value) {

			if (static::MAPPING_KEY === '') {

				if (!empty($this->tablePrefix)) {

					if (strpos($key, '_') !== false) {
						if ((strpos($key, 'fk_') === false) && (strpos($key, $this->tablePrefix) !== 0)) {
							continue;
						}
					} else {
						Registry::$keyMappings[$key] = $key;
					}
				}
			}

			$hasKey = !empty(Registry::$keyMappings[$key]);

			$this->handleValue($key, $value, $hasKey);
		}

		return $this;
	}

	public function __call($name, $arguments)
	{
		if (method_exists($this, $name)) {
			return call_user_func_array([$this, $name], $arguments);
		}

		$action = substr($name, 0, 3);

		$field = substr($name, 3);
		$field = ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $field)), '_');

		if ($action == 'set') {
			if (property_exists($this, $field)) {
				$this->$field = $arguments[0];
				return $this;
			}
			$this->data[$this->tablePrefix.$field] = $arguments[0];
			return $this;
		}

		if ($action == 'get') {
			if (property_exists($this, $field)) {
				return $this->$field;
			}
			return $this->data[$this->tablePrefix.$field] ?? null;
		}
	}


	private function handleValue(string $key, $value, bool $hasKey = false): bool
	{
		$originalKey = $key;

		if ($hasKey) {
			$key = Registry::$keyMappings[$key];
		} else {

			$key = $this->removePrefix($key, $this->tablePrefix);

			$key = $this->snakeToCamel($key);

			Registry::$keyMappings[$originalKey] = $key;
		}


		$this->{$key} = $value;
		return true;
	}

	private function snakeToCamel(string $value): string
	{
		return lcfirst(str_replace(' ', '', ucwords(strtr($value, '_-', ' '))));
	}

	private function removePrefix(string $str, string $prefix): string
	{
		if (is_array($prefix)) {
			$prefixRemoved = array_map(function ($prefix) use ($str) {
				$removed = $this->removePrefix($str, $prefix);
				return $removed === $str ? null : $removed;
			}, $prefix);

			$nullRemoved = array_filter($prefixRemoved);

			return reset($nullRemoved);
		}

		if ($prefix === '') {
			return $str;
		}

		return ltrim(stristr($str, '_'), '_');
	}

	public function getId(): int
	{
		return $this->data[$this->tablePrefix.'id'] ?? 0;
	}

	public function getTablePrefix(): string
	{
		return $this->tablePrefix;
	}

    public function getPartnerId(): int
    {
        return $this->data['fk_partner_id'] ?? 1;
    }

    protected function extractMappingValues(array $values = [], $tablePrefix = '') : array
    {
        if (static::MAPPING_KEY !== '') {

            $mapping = constant('\App\Helpers\Mapping::'.static::MAPPING_KEY.'_MAPPING');

            if (!empty($tablePrefix)) {
                foreach ($mapping as $index => $value) {
                    $mapping[$index] = str_replace($this->tablePrefix, $tablePrefix, $value);
                }
                $this->tablePrefix = $tablePrefix;
            }

            if (!empty($mapping['dependsOn'])) {
                unset($mapping['dependsOn']);
            }

            $values = array_intersect_key($values, array_flip($mapping));
        }

        return $values;
    }

    /**
     * @param \DateTime|string|int $date
     * @return \DateTime
     * @throws \Exception
     */
    protected function setDate($date)
    {
        if (empty($date)) {
            try {
                return (new \DateTime(date('Y-m-d H:i:s')));
            } catch (\Exception $e) {
                // errors being logged normally
            }
        }

        if (is_object($date) && (get_class($date) === 'DateTime')) {
            return (new \DateTime)->setTimestamp($date->getTimestamp());
        }

        // Create from timestamp
        if (is_integer($date)) {
            return (new \DateTime)->setTimestamp($date);
        }

        try {
            return new \DateTime($date, new \DateTimeZone('UTC'));
        } catch (\Exception $e) {
            // error handling stuff here.
        }
    }
}
