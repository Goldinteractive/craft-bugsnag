# Bugsnag Notifier for Craft
***

This is basically a fork of the official [Bugsnag Laravel Package](https://github.com/bugsnag/bugsnag-laravel).
Thanks for the good work and I hope you guys don't mind :)

The Bugsnag Notifier for the excellent [Craft CMS](https://buildwithcraft.com/) 
gives you instant notification of errors and exceptions. Once installed, 
the plugin will listen to the Yii Events `onError` and `onException` as 
[recommended by brand](http://craftcms.stackexchange.com/questions/10434/integrate-bugsnag/10440#10440).

[Bugsnag](https://bugsnag.com) captures errors in real-time from your web, 
mobile and desktop applications, helping you to understand and resolve them 
as fast as possible. [Create a free account](https://bugsnag.com) to start 
capturing errors from your applications.

## Installation

* Download this repo
* Rename the folder to `bugsnag` and place it into your Craft CMS Plugin directory (`craft/plugins`)
* In the newly created `craft/plugins/bugsnag` directory run `composer install`
* Navigate to your plugins page `/settings/plugins` and click Install
* Make sure to configure the plugin as described in the next section

## Configuration

1. Create a file `craft/config/bugsnag.php` that contains your API key:

2. Configure your `api_key`:

    ```php
    <?php # config/bugsnag.php

    return array(
        'api_key' => 'YOUR-API-KEY-HERE'
    );
    ```

3.  Optionally, you can add the `notify_release_stages` key to the same file
    above to define which [Craft environments](http://buildwithcraft.com/docs/multi-environment-configs)  will send Exceptions to Bugsnag.

    ```php
    return array(
        'api_key' => 'YOUR-API-KEY-HERE',
        'notify_release_stages' => ['production', 'staging']
    );
    ```
    
## Other

You can always grab the bugsnag instance from the bugsnag service to 
send your own errors and exceptions or register a beforeNotifyFunction.

```php
craft()->bugsnag->instance()->notifyError("ErrorType", "Something bad happened here too");
```

See the [setBeforeNotifyFunction](https://bugsnag.com/docs/notifiers/php#setbeforenotifyfunction)
documentation on the `bugsnag-php` library for more information.