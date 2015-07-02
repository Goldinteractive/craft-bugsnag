<?php namespace Craft;

use Yii;

class BugsnagPlugin extends BasePlugin {

    public function getName()
    {
        return Craft::t('Bugsnag');
    }

    public function getVersion()
    {
        return '0.1';
    }

    public function getDeveloper()
    {
        return 'Gold Interactive';
    }

    public function getDeveloperUrl()
    {
        return 'https://github.com/Goldinteractive/craft-bugsnag';
    }

    public function init()
    {
        // Make sure the class is not loaded elsewhere.
        if (!class_exists('Bugsnag_Client'))
        {
            require CRAFT_PLUGINS_PATH . '/bugsnag/vendor/autoload.php';
        }

        $this->listen();
    }

    private function listen()
    {
        $service = craft()->bugsnag;

        Yii::app()->onException = function($exception) use ($service)
        {
            $service->logException($exception->exception);
        };

        Yii::app()->onError = function($error) use ($service)
        {
            $service->logError($error->name, $error->message, ['file' => $error->file, 'line' => $error->line]);
        };
    }

}
