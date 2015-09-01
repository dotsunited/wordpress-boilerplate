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
