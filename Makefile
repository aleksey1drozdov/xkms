stop:
	cd ./docker/ && docker compose down
push:
	docker exec php-x bash -c "php /src/src/scripts/publisher.php"
healthcheck:
	docker exec php-x bash -c "php /src/src/scripts/healthcheck.php"
run:
	cd ./docker/ && docker compose build && docker compose up -d && docker exec php-x bash -c "composer install"