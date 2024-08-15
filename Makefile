NETWORK=playground
PHP_CONTAINER=kanye-west
DOCKER_COMPOSE_FILE=./docker/compose.yaml
CMD=docker compose -f $(DOCKER_COMPOSE_FILE) exec $(PHP_CONTAINER)
CMD_XDEBUG_OFF=docker compose -f $(DOCKER_COMPOSE_FILE) exec -e XDEBUG_MODE=off $(PHP_CONTAINER)
APP=/app

service-install:
	@docker network inspect $(NETWORK) >/dev/null 2>&1 || docker network create $(NETWORK)
	@docker compose -f $(DOCKER_COMPOSE_FILE) up  --build --remove-orphans -d
	@make composer-install
	@make env
#	@make database-sqlite
#	@make run-migrations



#docker compose commands
docker-up:
	@docker compose -f $(DOCKER_COMPOSE_FILE) up -d

docker-down:
	@docker compose -f $(DOCKER_COMPOSE_FILE) down --remove-orphans -v

generate-key:
	@$(CMD_XDEBUG_OFF) php artisan key:generate

generate-api-token:
	@$(CMD_XDEBUG_OFF) php artisan app:generate-auth-token

env:
	@cp app/.env.example  app/.env
	@make generate-key
	@make generate-api-token


docker-bash:
	@$(CMD_XDEBUG_OFF) bash

artisan-xdebug:
	@$(CMD) php artisan $(filter-out $@,$(MAKECMDGOALS)) $${OPTIONS}

artisan:
	@$(CMD_XDEBUG_OFF) php artisan $(filter-out $@,$(MAKECMDGOALS)) $${OPTIONS}

composer:
	@$(CMD_XDEBUG_OFF) composer  $(filter-out $@,$(MAKECMDGOALS)) --no-interaction --working-dir=$(APP)

#composer for docker environment
composer-install:
	@$(CMD_XDEBUG_OFF) composer install --no-interaction --working-dir=$(APP)

composer-update:
	@$(CMD_XDEBUG_OFF) composer update --no-interaction --working-dir=$(APP)

run-migrations:
	@$(CMD_XDEBUG_OFF) php artisan migrate

unit-tests:
	@$(CMD) /app/vendor/bin/phpunit -c /app  --strict-coverage --coverage-clover coverage/unit-clover.xml --coverage-html coverage  --coverage-xml=coverage/coverage-xml  --log-junit=coverage/junit.xml

database-sqlite:
	 @if [ ! -f app/database/database.sqlite ]; then \
	  sqlite3 app/database/database.sqlite "VACUUM;"; \
	  echo "Created app/database/database.sqlite"; \
	 else \
	  echo "app/database/database.sqlite already exists"; \
	 fi

# Prevent make from interpreting the arguments as targets
%:
	@: