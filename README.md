Ferret
======

Creates a reference to a Drupal file stored in a private Github repo. Basically, it is an automation of this process: http://www.systemseed.com/blog/drush-make-private-git-repository-github

If you are using this to access a drush makefile in a private repo be sure to create ~/.curlrc with the following line in it:

```
--header "Accept: application/vnd.github.v3.raw"
```

You can then do something like

```
drush make [url_from_this_tool]
```

Screenshot:
https://www.evernote.com/shard/s1/sh/15a284a7-7134-408d-8fe4-e37da0504bd1/56ec85f7cc33b5b6545f2419c3a081aa
