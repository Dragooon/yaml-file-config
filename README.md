Yaml File Configuration
=======================
Simple library for loading and accessing configuration stored in .yml files. It relies on [symfony/yaml](http://github.com/symfony/yaml) for its
functions. The library avoids loading Yaml file until requested (lazy loading) to avoid unnecessary loading and parsing.

Installation
------------
You can install the project via composer

```composer require dragooon\yamlfileconfig```

Usage
-----
### config.yml
```yml
timeout: 10
parameter:
  a: 1
  b: 2
name: abc
```

```php
$config = new \Dragooon\YamlFileConfig\YamlFileConfig('config.yml');
echo $config['timeout']; // 10
echo $config['parameter']['a']; // 1;
echo $config->get('name'); // abc

// You can also modify the configuration by either of the following
$config['timeout'] = 20;
$config->set('parameter', [
    'a' => 2,
    'b' => 3,
]);

// And finally save the file to write into config.yml
$config->save();
```
License
-------
The project is licensed under The MIT License. See LICENSE for more information.
