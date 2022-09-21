# Client library for finAPI Access

Generated by the [OpenAPI Generator](https://openapi-generator.tech) project.

## Overview
This lightweight extensible client library is [PSR-7](https://www.php-fig.org/psr/psr-7), [PSR-11](https://www.php-fig.org/psr/psr-11), [PSR-17](https://www.php-fig.org/psr/psr-17) and [PSR-18](https://www.php-fig.org/psr/psr-18) complaint and relies on:

- PHP: >=7.3
- [Data Transfer](https://github.com/Articus/DataTransfer): >=0.5


## How to use

This library can be used either as a separate package (just deploy generated files to your package repository and add dependency `"/":"1.0.0"` to your project `composer.json`) or as a part of your project (just copy generated code from `src` and merge generated `composer.json` into your project `composer.json`).

First you need an implementation for [PSR-7](https://packagist.org/packages/psr/http-message) and [PSR-17](https://packagist.org/packages/psr/http-factory) interfaces. Usually it is a single package, and your project might already have one among its dependencies (for example if it is some web service). Otherwise, https://packagist.org/providers/psr/http-message-implementation and https://packagist.org/providers/psr/http-factory-implementation may help to find some suitable options.

Next choose an implementation for [PSR-18 interfaces](https://packagist.org/packages/psr/http-client). https://packagist.org/providers/psr/http-client-implementation may help to find some suitable options.

Then check content types for API requests you intend to send and API responses you intend to receive. For each unique content type you will need an implementation of [`OpenAPIGenerator\APIClient\BodyCoderInterface`](https://github.com/Articus/OpenAPIGeneratorAPIClient-PHP/blob/master/src/OpenAPIGenerator/APIClient/BodyCoderInterface.php) to encode request bodies and decode response bodies. Currently, only [`application/json` body coder](https://github.com/Articus/OpenAPIGeneratorAPIClient-PHP/blob/master/src/OpenAPIGenerator/APIClient/BodyCoder/Json.php) is provided out-of-the-box.

After that review security requirements for API operations you intend to use. For each unique security scheme you will need an implementation of [OpenAPIGenerator\APIClient\SecurityProviderInterface](https://github.com/Articus/OpenAPIGeneratorAPIClient-PHP/blob/master/src/OpenAPIGenerator/APIClient/SecurityProviderInterface.php). Currently, only [HTTP Bearer authentication](https://github.com/Articus/OpenAPIGeneratorAPIClient-PHP/blob/master/src/OpenAPIGenerator/APIClient/SecurityProvider/HttpBearer.php) is supported out-of-the-box.

The last step is to configure and wire all services together. It is highly advisable to use [PSR-11 container](https://packagist.org/packages/psr/container) for that. If you have not selected one for your project yet, https://packagist.org/providers/psr/container-implementation may help to find some suitable options. Here is a sample wiring configuration for `"laminas/laminas-servicemanager"`, `"laminas/laminas-diactoros"` and `"symfony/http-client"` (consult generated `composer.json` for the exact versions of used packages):

```PHP
<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$dependencies = [
    'invokables' => [
        Psr\Http\Message\RequestFactoryInterface::class => Laminas\Diactoros\RequestFactory::class,
        Psr\Http\Message\ResponseFactoryInterface::class => Laminas\Diactoros\ResponseFactory::class,
        Psr\Http\Message\StreamFactoryInterface::class => Laminas\Diactoros\StreamFactory::class,
    ],
    'factories' => [
        App\ApiClient::class => App\ApiClientFactory::class,

        Articus\DataTransfer\Service::class => Articus\DataTransfer\Factory::class,
        Articus\DataTransfer\MetadataProvider\Annotation::class => Articus\DataTransfer\MetadataProvider\Factory\Annotation::class,
        Articus\DataTransfer\Strategy\PluginManager::class => Articus\DataTransfer\Strategy\Factory\PluginManager::class,
        Articus\DataTransfer\Validator\PluginManager::class => Articus\DataTransfer\Validator\Factory\PluginManager::class,
        Laminas\Validator\ValidatorPluginManager::class => Laminas\Validator\ValidatorPluginManagerFactory::class,

        OpenAPIGenerator\APIClient\SecurityProvider\PluginManager::class => OpenAPIGenerator\APIClient\SecurityProvider\Factory\PluginManager::class,
        OpenAPIGenerator\APIClient\BodyCoder\PluginManager::class => OpenAPIGenerator\APIClient\BodyCoder\Factory\PluginManager::class,

        Psr\Http\Client\ClientInterface::class => function (Psr\Container\ContainerInterface $container)
        {
            return new Symfony\Component\HttpClient\Psr18Client(
                new Symfony\Component\HttpClient\NativeHttpClient(),
                $container->get(Psr\Http\Message\ResponseFactoryInterface::class),
                $container->get(Psr\Http\Message\StreamFactoryInterface::class)
            );
        },
    ],
    'aliases' => [
        Articus\DataTransfer\ClassMetadataProviderInterface::class => Articus\DataTransfer\MetadataProvider\Annotation::class,
        Articus\DataTransfer\FieldMetadataProviderInterface::class => Articus\DataTransfer\MetadataProvider\Annotation::class,
    ],
];
$config = [
    'dependencies' => $dependencies,

    //Configure DataTransfer library
    Articus\DataTransfer\Strategy\PluginManager::class => [
        'invokables' => [
            'QueryStringScalar' => OpenAPIGenerator\Common\Strategy\QueryStringScalar::class,
            'QueryStringScalarArray' => OpenAPIGenerator\Common\Strategy\QueryStringScalarArray::class,
        ],
          'factories' => [
            'Date' => OpenAPIGenerator\Common\Strategy\Factory\ImmutableDate::class,
            'DateTime' => OpenAPIGenerator\Common\Strategy\Factory\ImmutableDateTime::class,
            'ObjectList' => OpenAPIGenerator\Common\Strategy\Factory\NoArgObjectList::class,
            'ObjectMap' => OpenAPIGenerator\Common\Strategy\Factory\NoArgObjectMap::class,
            'ScalarList' => OpenAPIGenerator\Common\Strategy\Factory\ScalarList::class,
            'ScalarMap' => OpenAPIGenerator\Common\Strategy\Factory\ScalarMap::class,
        ]
    ],
    Articus\DataTransfer\Validator\PluginManager::class => [
        'invokables' => [
            'Scalar' => OpenAPIGenerator\Common\Validator\Scalar::class,
            'QueryStringScalar' => OpenAPIGenerator\Common\Validator\QueryStringScalar::class,
            'QueryStringScalarArray' => OpenAPIGenerator\Common\Validator\QueryStringScalarArray::class,
        ],
        'abstract_factories' => [
            Articus\DataTransfer\Validator\Factory\Laminas::class,
        ],
    ],
    'validators' => [
        'invokables' => [
            'Count' => Laminas\Validator\IsCountable::class,
        ],
    ],

    //Set API server URL here
    App\ApiClient::class => [
        //'server_url' => 'https://api.url',
    ],

    //Register body coders for used content types here
    OpenAPIGenerator\APIClient\BodyCoder\PluginManager::class => [
        'factories' => [
            //'another/mime-type' => AnotherMimeTypeBodyCoder::class
        ],
    ],

    //Register security providers for used security schemes here
    OpenAPIGenerator\APIClient\SecurityProvider\PluginManager::class => [
        'factories' => [
            //'another-security-scheme' => AnotherSecuritySchemeProvider::class,
        ],
        'aliases' => [
            //'custom-name-for-htt-bearer' => OpenAPIGenerator\APIClient\SecurityProvider\HttpBearer::class,
        ],
    ],
];
$container = new Laminas\ServiceManager\ServiceManager($dependencies);
$container->setService('config', $config);
$container->setAlias('Config', 'config');

/** @var App\ApiClient $client */
$client = $container->get(App\ApiClient::class);
//... and now you can use client methods to call API operations :)

//And one more sample: how to set token for HTTP Bearer authentication
/** @var OpenAPIGenerator\APIClient\SecurityProvider\PluginManager $securityProviders */
$securityProviders = $container->get(OpenAPIGenerator\APIClient\SecurityProvider\PluginManager::class);
/** @var OpenAPIGenerator\APIClient\SecurityProvider\HttpBearer $httpBearer */
$httpBearer = $securityProviders->get(OpenAPIGenerator\APIClient\SecurityProvider\HttpBearer::class);
$httpBearer->setToken('some-token');

```
