# Gitamine 

US: **/ɡɪtəˈ.miː.n/** \
UK: **/ɡɪtˈæ.miːn/**

## requirements

* Linux/Mac
* php7.1
* php curl
* php zip
* Git

## Installation

```bash
$ composer global require gitamine/gitamine 
```

## Usage

In your git project run:

```bash
$ gitamine init
```

After that you will need to create in your root project folder a gitamine file

 
```yaml
# gitamine.yaml
gitamine:
    __event__:
        __plugin1__: ~
        __plugin2__: ~
        #...
```

For example, this will assure that the commit will execute phpunit, and if it fails, then the commit won't be done.

```yaml
# gitamine.yaml
gitamine:
    pre-commit:
        phpunit: ~
```

## How to create a plugin

TODO
