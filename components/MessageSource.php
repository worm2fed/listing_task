<?php

namespace app\components;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;

/**
 * This class redefines only one method to use nested array for translations
 */
class MessageSource extends \yii\i18n\PhpMessageSource
{
    /**
     * {@inheritdoc}
     */
    protected function loadMessagesFromFile($messageFile): ?array
    {
        $result = parent::loadMessagesFromFile($messageFile);

        if ($result !== null) {
            $result = self::convertArray($result);
        }

        return $result;
    }

    /**
     * This method converts nested array to one dimensional one, where its 
     * keys separated by dots
     * 
     * Example
     * $nestedArray = [
     *     'one' => [
     *         'two' => 'three'
     *     ]
     * ];
     * $array = convertArray($nestedArray); // '[one.two' => 'three']
     * 
     * @param array $nestedArray to convert
     * 
     * @return array
     */
    private static function convertArray(array $nestedArray): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($nestedArray),
            RecursiveIteratorIterator::SELF_FIRST
        );
        $path = $result = [];

        foreach ($iterator as $key => $value) {
            $path[$iterator->getDepth()] = $key;

            if (!is_array($value)) {
                $result[implode('.', array_slice($path, 0, $iterator->getDepth() + 1))] = $value;
            }
        }

        return $result;
    }
}
