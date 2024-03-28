# Correlation ID Symfony Bundle

![PHP >= 8.1](https://img.shields.io/static/v1?label=PHP&message=^8.1&color=787CB5&style=for-the-badge&logo=php)
![phpstan Level 8](https://img.shields.io/static/v1?label=phpstan&message=Level%208&color=%3CCOLOR%3E&style=for-the-badge)
![License: MIT](https://img.shields.io/static/v1?label=License&message=MIT&color=%3CCOLOR%3E&style=for-the-badge)
[![Code Quality](https://img.shields.io/scrutinizer/g/Phauthentic/correlation-id-symfony-bundle/master.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/Phauthentic/correlation-id-symfony-bundle/)
<!--[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/Phauthentic/correlation-id-symfony-bundle/master.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/Phauthentic/correlation-id-symfony-bundle/)-->


This is a Symfony bridge for the framework agnostic [Correlation ID library](https://github.com/Phauthentic/correlation-id).

> A Correlation ID, also known as a Transit ID, is a unique identifier value that is attached to requests and messages that allow reference to a particular transaction or event chain. The Correlation Pattern, which depends on the use of Correlation ID is a well documented Enterprise Integration Pattern.

 * [The value of a correlation ID](https://blog.rapid7.com/2016/12/23/the-value-of-correlation-ids/)
 * [Identity Correlation on Wikipedia](https://en.wikipedia.org/wiki/Identity_correlation)

## Installation

```sh
composer require phauthentic/correlation-id-symfony-bundle
```

## Configuration

You can configure three different settings to control the behavior:

* `response_header_name` - The name of the response header for the ID.
* `request_header_name` - The name of the request header for the ID.
* `pass_through` - If the ID from the request should be passed to the response enable this. This is useful if you are dealing with a microservice that is not exposed to the public but gets further actions delegated from the entry point and must retain the original ID.

`config/correlation_id.yaml`:

```yaml
correlation_id:
    response_header_name: 'X-Correlation-ID'
    request_header_name: 'X-Correlation-ID'
    pass_through: false
```

## Copyright & License

Licensed under the [MIT license](LICENSE).

Copyright (c) [Phauthentic](https://github.com/Phauthentic) / Florian Krämer
