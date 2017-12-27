# Gitamine 

US: **/ɡɪtəˈ.miː.n/** \
UK: **/ɡɪtˈæ.miːn/**

## requirements

* Linux/Mac
* php7.1
* php curl
* php zip
* Git

## initial setup

```bash
# ln -s bin/console /usr/local/bin/console
$ gitamine init
```

## TODO

- decide how a plugin comunicates with gitanime 
    * gitanime sends all data (only options as flags)
    * plugin executes gitanime commands to get info (gitamine commands)
- allow plugins to extend hooks (future)
- phpunit plugin
- phpcs plugin
- composer plugin
- codeception plugin
- symfony plugin
    * Create a listenér for Nektria to add [MIGRATION] when a migration is created
    * Create a listenér for Nektria to add [COMPOSER] when composer is updated is created/updated
        * composer install => checkout, created/updated
    * Run composer install when the composer has been created/updated

Gitamine exception -> error code 1
Plugin             -> error code 2
