[NewRelic](http://newrelic.com) PHP agent integration for [Nette Framework](http://nette.org)
=============================================================================================

[![Build Status](https://img.shields.io/travis/Vrtak-CZ/NewRelic-Nette.svg?style=flat-square)](https://travis-ci.org/Vrtak-CZ/NewRelic-Nette)
[![Latest Stable Version](https://img.shields.io/packagist/v/vrtak-cz/newrelic-nette.svg?style=flat-square)](https://packagist.org/packages/vrtak-cz/newrelic-nette)
[![Composer Downloads](https://img.shields.io/packagist/dt/vrtak-cz/newrelic-nette.svg?style=flat-square)](https://packagist.org/packages/vrtak-cz/newrelic-nette)

## Versions

| State  | Version | Branch |  Nette |     PHP |
|--------|--------:|--------|-------:|--------:|
| stable |  `^8.0` | master | `^3.0` | `>=7.1` |
| stable |  `^7.0` | master | `^2.4` | `>=5.6` |

### Installation

```
composer require contributte\newrelic
```

edit `app/config/config.neon`

```yaml
extensions:
    newrelic: Contributte\NewRelic\DI\NewRelicExtension
```

### Config

```yaml
newrelic:
    enabled: Yes #default
    appName: YourApplicationName #optional
    license: yourLicenseCode #optional
    actionKey: action # default - optional - action parameter name
    logLevel: #defaults
        - critical
        - exception
        - error

    # optional options with default values
    rum:
        enabled: auto # other options are Yes/No
    transactionTracer:
        enabled: Yes
        detail: 1
        recordSql: obfuscated
        slowSql: Yes
        threshold: apdex_f
        stackTraceThreshold: 500
        explainThreshold: 500
    errorCollector:
        enabled: Yes
        recordDatabaseErrors: Yes
    parameters:
        capture: No
        ignored: []
    customParameters:
        paramName: paramValue
```

### Realtime User Monitoring

add this component factory to your base presenter

```php
/**
 * @var \Contributte\NewRelic\RUM\HeaderControl
 * @inject
 */
protected $headerControl;

/**
 * @var \Contributte\NewRelic\RUM\FooterControl
 * @inject
 */
protected $footerControl;

protected function createComponentNewRelicHeader()
{
    $this->headerControl->disableScriptTag(); // optional
    return $this->headerControl;
}

protected function createComponentNewRelicFooter()
{
    $this->footerControl->disableScriptTag(); // optional
    return $this->footerControl;
}
```

and add this to your `@layout` header (before `</head>`)

```smarty
{control newRelicHeader}
```

and add this to your `@layout` footer (before `</body>`)

```smarty
{control newRelicFooter}
```

### Tracy

```php
$logLevel = [ // default (NULL means default)
    \Tracy\Logger::CRITICAL,
    \Tracy\Logger::EXCEPTION,
    \Tracy\Logger::ERROR,
];
$appName = 'PHP Application'; // default (NULL means default)
$license = 'your_licence_key';

\Contributte\NewRelic\Tracy\Bootstrap::init($logLevel, $appName, $license); // all parameters are optional
```

License
-------
NewRelic Nette extension is licensed under the MIT License - see the LICENSE file for details
