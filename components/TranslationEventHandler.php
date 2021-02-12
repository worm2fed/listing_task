<?php

namespace app\components;

use yii\i18n\MissingTranslationEvent;

/**
 * [Description TranslationEventHandler]
 */
class TranslationEventHandler
{
    /**
     * @param MissingTranslationEvent $event
     * 
     * @return [type]
     */
    public static function handleMissingTranslation(
        MissingTranslationEvent $event
    ) {
        $event->translatedMessage = "@MISSING: {$event->category}." .
            "{$event->message} FOR LANGUAGE {$event->language} @";
    }
}
