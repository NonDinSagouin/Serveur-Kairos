# Variables
DOCKER_PHP_SERVICE=php

# Commande pour installer Doctrine
install-composer:
	@docker-compose exec $(DOCKER_PHP_SERVICE) composer require doctrine/orm
# Commande pour installer jQuery
install-npm:
	@docker-compose exec $(DOCKER_PHP_SERVICE) npm install

# Commande pour tout initialiser : build des conteneurs et installation de Doctrine
init: build install-composer install-npm
	@echo "Installation terminée."

# Commande pour démarrer et reconstruire les conteneurs Docker
build:
	@docker-compose up --build -d

# Commande pour arrêter les conteneurs
stop:
	@docker-compose down
