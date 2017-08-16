The Dots United Wordpress Boilerplate
===
A barebones, clean and minimalist WordPress Boilerplate, developed at
[Dots United](https://dotsunited.de/) as a foundation for modern, maintainable
and lightning fast WordPress based projects.

A Demo is available [here](http://wordpress-boilerplate.dotsunited.de/).

Features
---

* [Maximum possible PageSpeed Insights score](https://developers.google.com/speed/pagespeed/insights/?url=http%3A%2F%2Fwordpress-boilerplate.dotsunited.de%2F&tab=mobile)
* [Webpack](https://github.com/webpack/webpack) workflow
* [Composer](https://github.com/composer/composer) enabled
* Clean, maintainable and scalable project structure
* No bloat

Setup
---
Create new project with

```bash
composer create-project dotsunited/wordpress-boilerplate my-project
```

Run docker-compose (Wordpress 4.8.1 & latest MySQL server)

```bash
cd my-project
docker-compose up --build
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

You can use [webfont-dl](https://github.com/mmastrac/webfont-dl) to download
webfonts from Google.

```bash
webfont-dl http://fonts.googleapis.com/css?family=Roboto --out assets/main/core/fonts/fonts.css --woff1=link --woff2=omit --svg=omit --ttf=omit --eot=omit
```

Docker
---

- Apache 2.4
- PHP 7.1
- MySQL (latest)
- Wordpress (4.8.1)

License
---

Copyright (c) 2015-2016 Dots United GmbH.
Released under the [MIT](LICENSE?raw=1) license.
