<?php

namespace Craft;

use Bugsnag_Client;

class BugsnagService extends BaseApplicationComponent
{
    /**
     * @var Bugsnag_Client
     */
    protected $instance = null;

    public function logException($exception)
    {
        $this->instance()->notifyException($exception, null, "error");
    }

    public function logError($name, $message, $meta)
    {
        $this->instance()->notifyError($name, $message, $meta, "error");
    }

    public function instance()
    {
        if ($this->instance !== null) {
            return $this->instance;
        }

        $config = craft()->config;
        $client = new Bugsnag_Client($config->get('api_key', 'bugsnag'));

        $client->setStripPath(craft()->getBasePath());
        $client->setProjectRoot(craft()->getBasePath());
        $client->setAutoNotify(false);
        $client->setBatchSending(false);
        $client->setReleaseStage(CRAFT_ENVIRONMENT);
        $client->setNotifier(array(
            'name'    => craft()->plugins->getPlugin('bugsnag')->getName(),
            'version' => craft()->plugins->getPlugin('bugsnag')->getVersion(),
            'url'     => 'https://github.com/Goldinteractive/craft-bugsnag'
        ));

        if ($config->exists('notify_release_stages', 'bugsnag') && is_array($config->get('notify_release_stages',
                'bugsnag'))
        ) {
            $client->setNotifyReleaseStages($config->get('notify_release_stages', 'bugsnag'));
        }

        if ($config->exists('endpoint', 'bugsnag')) {
            $client->setEndpoint($config->get('endpoint', 'bugsnag'));
        }

        if ($config->exists('filters', 'bugsnag') && is_array($config->get('filters', 'bugsnag'))) {
            $client->setFilters($config->get('filters', 'bugsnag'));
        }

        if ($config->exists('proxy', 'bugsnag') && is_array($config->get('proxy', 'bugsnag'))) {
            $client->setProxySettings($config->get('proxy', 'bugsnag'));
        }

        if (craft()->userSession->isLoggedIn()) {
            $user = craft()->userSession->getUser();

            $client->setUser([
                'id'   => $user->id,
                'name' => (string)$user,
            ]);
        }

        return $client;
    }
}