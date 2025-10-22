test:
	./vendor/bin/phpunit --colors=always tests

phpstan:
	./vendor/bin/phpstan analyse src tests --level=max

psalm:
	./vendor/bin/psalm

cs:
	./vendor/bin/phpcs src tests