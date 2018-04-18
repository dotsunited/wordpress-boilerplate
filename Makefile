deps: node_modules vendor
.PHONY: deps

node_modules: package.json package-lock.json
	npm install

vendor: composer.json composer.lock
	composer self-update
	composer validate --no-check-publish
	composer install
