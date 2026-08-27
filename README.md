# Dots United WordPress Boilerplate

A barebones, clean and minimalist WordPress Boilerplate, developed at
[Dots United](https://dotsunited.de/) as a foundation for modern, maintainable
and lightning fast WordPress based projects.

Gutenberg ready.

A Demo is available [here](http://wordpress-boilerplate.dotsunited.de/).

## Features

- [Maximum possible PageSpeed Insights score](https://developers.google.com/speed/pagespeed/insights/?url=http%3A%2F%2Fwordpress-boilerplate.dotsunited.de%2F&tab=mobile)
- [Bun](https://bun.sh) for fast all-in-one JavaScript runtime
- [Vite](https://github.com/vitejs/vite) for asset bundling
- [Composer](https://github.com/composer/composer) for PHP dependency management
- [Tailwind CSS](https://github.com/tailwindcss/tailwindcss) for utility-first CSS
- Clean, maintainable and scalable project structure
- No bloat

## Setup

Create a new project with:

```bash
composer create-project dotsunited/wordpress-boilerplate my-project
```

## Docker

Adjust the `docker-compose.yml` to your needs using a `docker-compose.override.yml` file (<https://docs.docker.com/compose/extends/>).

You can add a database dump using a `dump.sql.gz` or `dump.sql` file which will be imported on the first run. If a database dump is present, a new user with the following credentials will be automatically added:

```bash
Username: `localAdmin`
Password: `localPassword`
```

> ⚠️ Remember to remove or change the credentials in a production environment!

Multisite subfolders can be be configured by setting the `WORDPRESS_MULTISITE_PATHS` environment variable to e.g. `2=blog2,3=blog3`, resulting in the following URLs:

- <http://localhost:8080/>
- <http://localhost:8080/blog2/>
- <http://localhost:8080/blog3/>

If nothing is set, the ID of the corresponding blog will be used as a path, resulting in the following URLs:

- <http://localhost:8080/>
- <http://localhost:8080/2/>
- <http://localhost:8080/3/>

Start the Docker containers with

```bash
docker compose up -d
```

## Deployment

The GitHub Actions and GitLab templates build the frontend and Gutenberg assets
and deploy them with
[`ghcr.io/dotsunited/deploy:v0`](https://github.com/dotsunited/deploy).
See the deploy repository for all supported protocols and configuration options.

Configure at least these variables for each target environment:

```text
DEPLOY_PROTOCOL
DEPLOY_HOST
DEPLOY_USER
DEPLOY_REMOTE_PATH
```

For GitHub Actions, add connection values as environment variables and add
credentials as environment secrets. The environment name is the branch name
(`main` or `staging`). For GitLab, add the same values as CI/CD variables.

The templates deploy from `./public`. The deploy image reads tracked files
directly from Git and adds generated paths from `.deploy-include`.
`.deploy-ignore` protects WordPress core,
uploads, plugins, `.htaccess`, and other server-managed files. Unrelated remote
files, themes, and plugins are not deleted.

Deployment state is stored as `deploy.manifest.json`. Apply
`public/.htaccess.dist` on the server when the destination is a web root to
block public access to this file.

To deploy a generated `vendor/` directory, remove `/vendor/**` from
`.deploy-ignore`, add these rules to `.deploy-include`, include the directory
in the CI artifact, and run Composer in the build job:

```text
+ /vendor/
+ /vendor/**
```

```yaml
- run: composer install --no-dev --no-interaction --prefer-dist
```

## Plugins

> ℹ️ Automatic updates for plugins, themes and major core versions are disabled by default. You can enable them by removing or commenting the corresponding module inside `wp-content/mu-plugins/wordpress-boilerplate/wordpress-boilerplate.php`.

If you uncommented sentry lines in `docker-compose.yml` install [WP Sentry](https://wordpress.org/plugins/wp-sentry-integration/)

Be careful when using plugins which depend on jQuery.

Gravity Forms for example will enqueue jquery once a form is embedded into a
post or page.

In this case, you might include the form via an iFrame. You can use the
[gravity-forms-iframe](https://github.com/bradyvercher/gravity-forms-iframe)
plugin for easier integration.

## Webfonts

It is recommended to use local webfonts and not from external CDN's like
Google Fonts.

You can use [google-webfonts-helper](https://gwfh.mranftl.com/fonts)
to download webfonts from Google Fonts.

## License

Copyright (c) 2015-2026 Dots United GmbH.
Released under the [MIT](LICENSE) license.
