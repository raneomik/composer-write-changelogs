# composer-write-changelogs

composer-write-changelogs is a plugin for Composer. It displays some texts after each
Composer update to nicely summarize the modified packages with links to release
and compare urls and write it to .txt or .json file.

## Installation

You can install it either globally:

```shell
composer global require "spiriit/composer-write-changelogs"
```

or locally:

```shell
composer require --dev "spiriit/composer-write-changelogs"
```

## Usage

That's it! Composer will enable automatically the plugin as soon it's
installed. Just run your Composer updates as usual :)

If you no longer want to display summary, you can either:
- run your Composer command with the option `--no-plugins`
- uninstall the package

## Further documentation

Here is some documentation about the project:

* [Configuration, like gitlab hosts setup](doc/configuration.md)

You can see the current and past versions using one of the following:

* the `git tag` command

## Credits

* [Loïck Piera](https://https://github.com/pyrech/composer-changelogs) for the reused code base

## License

composer-write-changelogs is licensed under the MIT License - see the [LICENSE](LICENSE)
file for details.
