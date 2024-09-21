# Variables
DOCKER_PHP_SERVICE=php

# Commande pour démarrer et reconstruire les conteneurs Docker
build:
	@docker-compose up --build -d

# Commande pour tout initialiser : build des conteneurs et installation de Doctrine
init: build install-composer install-npm
	@echo "Installation terminée."

# Commande pour arrêter les conteneurs
stop:
	@docker-compose down
