The Dots United WordPress Boilerplate
===

A barebones, clean and minimalist WordPress Boilerplate, developed at
[Dots United](https://dotsunited.de/) as a foundation for modern, maintainable
and lightning fast WordPress based projects.

Gutenberg ready.

A Demo is available [here](http://wordpress-boilerplate.dotsunited.de/).

Features
---

* [Maximum possible PageSpeed Insights score](https://developers.google.com/speed/pagespeed/insights/?url=http%3A%2F%2Fwordpress-boilerplate.dotsunited.de%2F&tab=mobile)
* [Webpack](https://github.com/webpack/webpack) workflow
* [Composer](https://github.com/composer/composer) enabled
* [Tailwindcss](https://github.com/tailwindcss/tailwindcss) enabled
* Clean, maintainable and scalable project structure
* No bloat

Setup
---

Create new project with

```bash
composer create-project dotsunited/wordpress-boilerplate my-project
```

Docker
---

Copy the `docker-compose.yml.dist` to `docker-compose.yml` and
adjust the environment variables to your needs.

You can add a database dump with the filename `dump.sql.gz` or `dump.sql` which will be imported on the first run. Additionally a new user with the following credentials will be automatically added:

```bash
Username: `localAdmin`
Password: ´localPassword´
```

> ⚠️ Remember to remove or change the credentials in a production environment!

Start the docker containers with

```bash
docker composer up -d
```

Plugins
---

Be careful when using plugins which depend on jQuery.

Gravity Forms for example will enqueue jquery once a form is embedded into a
post or page.

In this case, you might include the form via an iFrame. You can use the
[gravity-forms-iframe](https://github.com/bradyvercher/gravity-forms-iframe)
plugin for easier integration.

Webfonts
---

It is recommended to use local webfonts and not from external CDN's like
Google Fonts.

You can use [google-webfonts-helper](https://google-webfonts-helper.herokuapp.com)
to download webfonts from Google Fonts.

License
---

Copyright (c) 2015-2022 Dots United GmbH.
Released under the [MIT](LICENSE) license.
