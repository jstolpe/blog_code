.PHONY: clean install test

clean:
	@rm -rf vendor composer.lock

install: clean
	composer install --no-suggest --no-scripts --no-progress --no-interaction

test: install
	vendor/bin/phpunit test/unit
