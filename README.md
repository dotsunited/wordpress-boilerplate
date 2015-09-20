Wordpress Boilerplate
===

Create new project with

```bash
composer create-project dotsunited/wordpress-boilerplate my-project
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
webfont-dl http://fonts.googleapis.com/css?family=Roboto --out assets/main/core/fonts/fonts.css --font-out=assets/main/core/fonts/ --woff1=link
```
