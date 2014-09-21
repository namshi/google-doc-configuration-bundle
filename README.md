# GoogleDocConfigurationBundle

<img align="right" width="250px" src="http://rs1img.memecdn.com/he-doesnt-know-that-feel-look-at-him-and-laugh_o_890917.jpg" />

> Configure your Symfony2 container from a Google Doc.
> Sounds crazy but it's even worse.

This bundle will let you use a Google Doc to store key-value
pairs and re-use them within your Symfony2 app: this means
that any human capable with interacting with a spreadsheet
can play around and configure your app.

The values are "public", in the sense that you will need to share
the Google Doc ("Publish to the web") so anyone with the link
can access it, even though guessing the URL of the doc isn't trivial.

In any case, you should use this tecnique to store things like

* cache TTL
* products per page
* banner URLs

and so on and so fort. **Do not** store passwords or sensitive data
there.

## Installation

You can easily install this library through
[composer](https://packagist.org/packages/namshi/google-doc-configuration-bundle):

```
"namshi/google-doc-configuration-bundle": "dev-master"
```

## Configuration

Simply define the config service, here we are using Redis
and gvalue to store config values from Google Docs to Redis
and read the cached values from a redis hash for performances:

``` yaml
parameters:
  namshi_google_doc_configuration.config.google_doc_key: 123456

services:
  config:
    class: Namshi\GoogleDocConfigurationBundle\Config\RedisConfig
    arguments: [@namshi_google_doc_configuration.predis, 'namshi.config', true]
```

The Google Doc key can be found from the URL of your Google Doc, which is something like
`https://docs.google.com/a/namshi.com/spreadsheet/ccc?key=123456&usp=drive_web#gid=0`, where
`123456` is the key of the document.

To check the format of the doc have a look at the [example one](https://docs.google.com/spreadsheet/ccc?key=0Au4X4OwTcvrSdG5oZkFXMXM5SUl4YVF5bDV2NmZiSmc&usp=sharing).

Then secure the 2 routes that the bundle exposes,
in the `security.yml`:

``` yaml
utility:
  pattern:    (^/namshi/update-config)|(^/namshi/config)
  http_basic:
    provider: ...
```

You can then check `http://domain.example/namshi/config` to check your configuration
and `http://domain.example/namshi/update-config` to update it from
the Google Doc.

## Tests

![b****-please](http://galeri2.uludagsozluk.com/342/bitch-please_459292.jpg)