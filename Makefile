.PHONY: up up-build down

export

start-build:
	docker compose up -d --build && docker-compose exec php sh /var/www/permissions.sh

start:
	docker compose up -d

down:
	docker compose down

down-v:
	docker compose down -v
