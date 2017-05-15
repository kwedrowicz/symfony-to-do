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

exec:
		@docker exec -i -t symfonytodo_app /bin/bash

ifconfig:
		sudo ifconfig lo0 alias 10.254.254.254
