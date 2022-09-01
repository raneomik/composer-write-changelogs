# Plugin configuration

This plugin supports some configuration.

## Location

Configuration can be setup by adding parameters in the `extra` section of your
`composer.json`.

```json
{
    "extra": {
        "composer-changelogs": {
            "{{ the configuration key }}": "{{ the configuration value }}",
        }
    }
}
```

This `composer-write-changelogs` extra config can be put either in your local
`composer.json` (the one of the project you are working on) or the global
one in your `.composer` home directory (like
`/home/{user}/.composer/composer.json` on Linux).

## Configuration available

The available configuration options are listed below:

### Gitlab hosts

Unlike Github or Bitbucket that have fixed domains, Gitlab instances are
self-hosted so there is no way to automatically detects that a domain
correspond to a Gitlab instance.

The `gitlab-hosts` option can be setup to inform the plugin about the hosts it
should consider as Gitlab instance.

```json
{
    "extra": {
        "composer-write-changelogs": {
            "gitlab-hosts": [
                "gitlab.my-company.org"
            ],
        }
    }
}
```

## WriteSummaryFile feature

composer-write-changelogs plugin allows to write summary changelogs into textual files
after you ran your `composer update` command.
This can be usefull if you need to exploit the changelogs.

Please read the full documentation below to enable and make use of this feature.

## Setup

By default, this feature is disabled. To enabled it, you just need to set up
some `extra` config in your composer.json:

```json
{
    "extra": {
        "composer-write-changelogs": {
          "write-summary-file": true,
          "changelogs-dir-path": "my/custom/path"
        }
    }
}
```

## Options available

### write-summary-file

This option is a boolean.

- `false` is the default option. It disables completely write summary file feature.

### changelogs-dir-path

This option should contain the path of the directory where write summary feature will write changelogs files.
The path can be either absolute or relative to the `composer.json` file containing the plugin
configuration.

By default, the changelogs directory will be created from the directory of the `composer.json` file containing the plugin
configuration.

