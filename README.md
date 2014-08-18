# OAuth 2.0 Server MongoDB bundle

Model layer for OAuth 2.0 server bundle for Symfony 2 framework.

* Develop: [![Build Status](https://secure.travis-ci.org/michalkvasnicak/oauth2-server-mongodb-bundle.png?branch=develop)](http://travis-ci.org/michalkvasnicak/oauth2-server-mongodb-bundle)
* Master: [![Build Status](https://secure.travis-ci.org/michalkvasnicak/oauth2-server-mongodb-bundle.png?branch=master)](http://travis-ci.org/michalkvasnicak/oauth2-server-mongodb-bundle)
* [![Coverage Status](https://img.shields.io/coveralls/michalkvasnicak/oauth2-server-mongodb-bundle.svg)](https://coveralls.io/r/michalkvasnicak/oauth2-server-mongodb-bundle?branch=develop)
* [![Gittip](http://img.shields.io/gittip/michalkvasnicak.svg)](https://www.gittip.com/michalkvasnicak)
* [![Flattr this git repo](http://api.flattr.com/button/flattr-badge-large.png)](https://flattr.com/submit/auto?user_id=kvasnicak.michal&url=https://github.com/michalkvasnicak/oauth2-server-mongodb-bundle&title=michalkvasnicak/oauth2-server-mongodb-bundle&language=php&tags=github&category=software)

## Requirements

* PHP >= 5.4
* HHVM
* doctrine/mongodb-odm-bundle: ~3.0
* symfony/security-bundle: >= ~2.5
* michalkvasnicak/oauth2-server-bundle: dev-develop

## Installation

Using composer

```yml
{
    "require": {
        "michalkvasnicak/oauth2-server-mongodb-bundle": "~1.0"
    }
}
```

## Configuration

### Default Doctrine ODM Documents

To use default documents from this bundle just enable bundle in `AppKernel.php`.

### Custom Doctrine ODM Documents

If you want to create your own documents then create documents that are extending abstract classes from this bundle and configure this bundle.

```yml
o_auth2_server_mongodb:
    document_classes:
        access_token: 'FQN of Access Token Doctrine ODM document'
        authorization_code: 'FQN of Authorization code Doctrine ODM document'
        client: 'FQN of Client Doctrine ODM document'
        refresh_token: 'FQN of Refresh Token Doctrine ODM document'
        user: 'FQN of User Doctrine ODM document'

    repository_classes:
        access_token: 'FQN of Access Token Doctrine ODM document repository'
        authorization_code: 'FQN of Authorization code Doctrine ODM document repository'
        client: 'FQN of Client Doctrine ODM document repository'
        refresh_token: 'FQN of Refresh Token Doctrine ODM document repository'
        user: 'FQN of User Doctrine ODM document repository'

    # scope document and repository is not defined because it is used only by other documents
    # but Scope has to implement OAuth2\Storage\IScope interface!
```


