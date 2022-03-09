test:
	@make test-cs
	@make test-unit
	@make test-acceptance

test-unit:
	./vendor/bin/phpunit tests

test-acceptance-ci:
	MODE=test ./vendor/bin/behat

test-acceptance:
	docker-compose up -d
	sleep 1 				# Sleep for now to ensure mock api is ready. We can do something less flaky later if needed.
	MODE=test ./vendor/bin/behat
	docker-compose down

test-cs:
	./vendor/bin/phpcs --standard=PSR12 ./src

fix-cs:
	./vendor/bin/phpcbf --standard=PSR12 ./src