include Makefile-variables

all: docker-build docker-up-no-deamon

dev-tools:
	cs-fixer

docker-build:
	docker-compose ${COMPOSE_FILE_OPTION} build

docker-up:
	docker-compose ${COMPOSE_FILE_OPTION} up -d

docker-up-no-deamon:
	docker-compose ${COMPOSE_FILE_OPTION} up

docker-stop:
	docker-compose ${COMPOSE_FILE_OPTION} stop

docker-rm:
	docker-compose ${COMPOSE_FILE_OPTION} rm

exec:
	docker exec -i -t symfonytodo_app /bin/bash

ifconfig:
	sudo ifconfig lo0 alias 10.254.254.254

cs-fixer:
	@docker exec -i -t symfonytodo_app /bin/bash -c "php php-cs-fixer.phar fix src --rules=@PSR1,@PSR2,@Symfony --verbose --show-progress=estimating"
