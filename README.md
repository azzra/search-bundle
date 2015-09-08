# Purjus Search Bundle

Simple wide site search base on event system.
Results are grouped by category so the results can be organized.

## Edit composer.json

Add repository

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/azzra/search-bundle"
    }
],
```


## Update composer

Use branch-dev master until stable release

```sh
composer require purjus/search-bundle dev-master
```


## Configuration

```yml
#app/config/config.yml
```


## Update AppKernel.php

```php
// PURJUS SEARCH BUNDLE
new Purjus\SearchBundle\PurjusSearchBundle(),
```

# TODO
* define a search category & search entity
