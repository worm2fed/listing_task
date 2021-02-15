<?php

namespace app\components;

use yii\i18n\MissingTranslationEvent;

/**
 * This class defines handler for missing translations
 */
class TranslationEventHandler
{
    /**
     * This is missing translation handler
     * 
     * @param MissingTranslationEvent $event
     * 
     * @return void
     */
    public static function handleMissingTranslation(
        MissingTranslationEvent $event
    ) {
        $event->translatedMessage = "@MISSING: {$event->category}." .
            "{$event->message} FOR LANGUAGE {$event->language} @";
    }
}
