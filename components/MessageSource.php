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

        if (!is_null($result)) {
            $result = self::convertArray($result);
        }

        return $result;
    }

    private static function convertArray(array $array): array
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveArrayIterator($array),
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
