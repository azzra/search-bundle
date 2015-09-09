# Purjus Search Bundle

Simple wide site search base on event system.
Results are grouped by category so the results can be organized.

## Installation

1. Edit composer.json

Add repository

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/azzra/search-bundle"
    }
],
```

2. Update composer

Use branch-dev master until stable release

```sh
composer require purjus/search-bundle dev-master
```

3. Enable the bundle in the kernel:

```php
// app/AppKernel.php
new Purjus\SearchBundle\PurjusSearchBundle(),
```

## Usage

#### Expose route

```yml
# app/config/routing.yml
purjus_search:
    resource: "@PurjusSearchBundle/Controller/"
    type:     annotation
    prefix:   /search/
```

5. Configuration

**Optionnal**, should work out of the box.

```yml
# app/config/config.yml
purjus_search:
    min_length: 3 # minimum lenght for searching a string
    max_entries: 2 # maximum entries in a group
```


## Create a searcher

You have to create a "searcher" if you want add result to the search page.

1. Create a `Searcher` class that implements use `Purjus\SearchBundle\Model\SearcherInterface`. This class must have a `search()` method that returns a `Purjus\SearchBundle\Entity\Group`.

```php
namespace My\Bundle\Searcher;

use Purjus\SearchBundle\Entity\Group;
use Purjus\SearchBundle\Entity\Entry;
use Purjus\SearchBundle\Model\SearcherInterface;
use Purjus\SearchBundle\Searcher\PurjusSearcher;

class FakeSearcher extends PurjusSearcher implements SearcherInterface
{
    public function search($term, array $options = array())
    {
        
        // mandatory if you use $this->addToMax()
        $this->options = $options;
        
        $group = new Group('What', 'http://...');
        
        $results = ...;
        foreach ($results as $result) {
            $entry = new Entry($result['name'], $result['url'], $result['description']);
            if (!$this->addToMax($group, $entry)) {
                break;
            }
        }
        
        return $group;
        
    }
```

2. Add this class as a service tagged with dpn_xml_sitemap.generator:

```yml
parameters:
    purjus_page.searcher.page.class: Purjus\VscmsBundle\Searcher\PageSearcher

services:
    purjus_page.searcher.page:
        class: %purjus_page.searcher.page.class%
        tags:
            - { name: purjus_search.searcher }
        arguments: # do what you want here
            - @router
            - @doctrine.orm.entity_manager
```

# TODO
* HTML / API
