deps: node_modules vendor
.PHONY: deps

node_modules: package.json package-lock.json
	npm install
	# Workaround to prevent always running this target
	touch node_modules

vendor: composer.json composer.lock
	composer self-update
	composer validate --no-check-publish
	composer install
