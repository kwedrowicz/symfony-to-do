include Makefile-variables

all: docker-build docker-up

docker-build:
	docker-compose ${COMPOSE_FILE_OPTION} build

docker-up:
	docker-compose ${COMPOSE_FILE_OPTION} up -d

docker-stop:
	docker-compose ${COMPOSE_FILE_OPTION} stop

docker-rm:
	docker-compose ${COMPOSE_FILE_OPTION} rm

build-and-run:
		@if [ "$(system)" = "" ]; then \
				echo "system not set"; \
				exit 1; \
        fi
		@docker-compose build
		@if [ "$(system)" = "mac" ]; then \
				docker-sync-stack start; \
		else \
				docker-compose up; \
		fi

run:
		@if [ "$(system)" = "" ]; then \
				echo "system not set"; \
				exit 1; \
		fi
		@if [ "$(system)" = "mac" ]; then \
				docker-sync-stack start; \
		else \
				docker-compose up; \
		fi

exec:
		@docker exec -i -t symfonytodo_app /bin/bash

ifconfig:
		sudo ifconfig lo0 alias 10.254.254.254
