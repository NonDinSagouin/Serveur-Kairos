# Variables
DOCKER_PHP_SERVICE=php

#COLORS
GREEN  = \033[0;32m
WHITE  = \033[m
YELLOW = \033[0;33m
RESET  = \033[m

HELP_FUN = \
	%help; \
    while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
	print "usage: make [target]\n\n"; \
	for (sort keys %help) { \
	print "${WHITE}$$_:${RESET}\n"; \
	for (@{$$help{$$_}}) { \
	$$sep = " " x (32 - length $$_->[0]); \
	print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
	}; \
	print "\n"; }

help: ##@default Show this help.
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)


## ----------------------------------------------------------------
## DOCKER
## ----------------------------------------------------------------

init: build install-composer install-npm ##@docker Initialiser : build des conteneurs et installation de Doctrine
	@echo "Installation terminée."

install-composer: ##@docker Installer Doctrine
	@docker-compose exec $(DOCKER_PHP_SERVICE) composer require doctrine/orm
	
install-npm: ##@docker Installer jQuery
	@docker-compose exec $(DOCKER_PHP_SERVICE) npm install

build: ##@docker Démarrer et reconstruire les conteneurs Docker
	@docker-compose up --build -d

stop: ##@docker Arrêter les conteneurs
	@docker-compose down
