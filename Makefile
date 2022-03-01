include .env

#silent by default
ifndef VERBOSE
.SILENT:
endif

start:
	$(call do_start)

setup:
	$(call do_setup)

restart:
	$(call do_restart)

update:
	$(call do_update)

cc:
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console cache:clear'

stop:
	$(call do_stop)

destroy:
	$(call do_destroy)

recreate:
	$(call do_recreate)

test:
	$(call do_test)

test-f:
	$(call do_test_filter)

import-db:
	docker exec -i ${APP_NAME}_database bash -c 'exec mysql -uroot -plemp lemp' < $(FILE)

ssh:
	docker exec -it ${APP_NAME}_php sh

help:
	$(call do_display_commands)

info:
	$(call do_display_app_info)

helm-dry:
	helm install --debug --dry-run documentsly ./.kubernetes/documentsly

define do_db_healthcheck
	docker exec -it ${APP_NAME}_php sh -c 'chmod +x /app/.docker/php/database-healthcheck.sh'
	docker exec -it ${APP_NAME}_php sh -c '/app/.docker/php/database-healthcheck.sh'
endef

define do_start
	docker-compose up -d
	docker exec -it ${APP_NAME}_php sh -c 'composer install --prefer-dist --no-progress --optimize-autoloader'
	$(call do_db_healthcheck)
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:m:m --no-interaction'
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} started\e[0m'
	$(call do_display_commands)
	$(call do_display_app_info)
endef

define do_setup
	docker-compose up -d
	docker exec -it ${APP_NAME}_php sh -c 'composer install --prefer-dist --no-progress --optimize-autoloader'
	$(call do_db_healthcheck)
	docker exec -it ${APP_NAME}_php sh -c  'chown web:web -R .'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console cache:clear'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:d:d --if-exists --force'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:d:c --if-not-exists'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:m:m --no-interaction'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:f:l -q'
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} setup completed\e[0m'
	$(call do_display_commands)
	$(call do_display_app_info)
endef

define do_restart
	docker-compose down
	docker-compose up -d
	docker exec -it ${APP_NAME}_php sh -c 'composer install --prefer-dist --no-progress --optimize-autoloader'
	$(call do_db_healthcheck)
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:m:m --no-interaction'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console cache:clear'
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} restarted\e[0m'
	$(call do_display_commands)
	$(call do_display_app_info)
endef

define do_update
	docker exec -it ${APP_NAME}_php sh -c 'composer install --prefer-dist --no-progress --optimize-autoloader'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console d:m:m --no-interaction'
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} updated\e[0m'
endef

define do_stop
	docker-compose down
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} stopped\e[0m'
endef

define do_destroy
	docker-compose down --volumes
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} stopped and data deleted\e[0m'
endef

define do_recreate
	$(call do_destroy)
	$(call do_setup)
	echo -e '\n'
	echo -e '\e[42m${APP_NAME} re-created\e[0m'
endef

define do_test
	echo -e 'Testing. Testing. 1,2,3...'
	docker exec -it ${APP_NAME}_php sh -c 'rm var/test.db || true'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console doctrine:schema:create --env=test'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/phpunit --stop-on-failure --stop-on-error'
	echo -e '\n'
	echo -e '\e[42mTests completed\e[0m'
endef

define do_test_filter
	echo -e 'Testing. Testing. 1,2,3...'
	docker exec -it ${APP_NAME}_php sh -c 'rm var/test.db'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/console doctrine:schema:create --env=test'
	docker exec -it ${APP_NAME}_php sh -c 'php bin/phpunit --stop-on-failure --stop-on-error --filter=${FILTER}'
	echo -e '\n'
	echo -e '\e[42mTests completed\e[0m'
endef


define do_display_app_info
	echo -e '\n'
	echo -e '\e[1m--- ${APP_NAME} APP INFO ---\e[0m'
	echo -e '\n'
	echo -e 'https://${APP_NAME}.docker.test/'
	echo -e 'Database: https://${APP_NAME}-db.docker.test'
	echo -e 'To resolve the browser SSL errors, exceute the following commands:\n'
	echo -e '\tWindows (in powershell as admin): certutil -addstore -f "ROOT" .docker/certs/docker.crt\n'
	echo -e '\tMacOS: sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain .docker/certs/docker.crt'
endef

define do_display_commands
	echo -e '\n'
	echo -e '--- AVAILABLE COMMANDS ---'
	echo -e '\n'
	echo -e 'Setup the local development environment for ${APP_NAME}: \e[36mmake \e[0m\e[1msetup\e[0m'
	echo -e 'Stop the running app: \e[36mmake \e[0m\e[1mstop\e[0m'
	echo -e 'Stop the running app and delete the data: \e[36mmake \e[0m\e[1mdestroy\e[0m'
	echo -e 'Destroy the local environment and set it up again: \e[36mmake \e[0m\e[1mrecreate\e[0m'
	echo -e 'Start an app that has already been setup: \e[36mmake \e[0m\e[1mstart\e[0m'
	echo -e 'Restart an app that has already been setup: \e[36mmake \e[0m\e[1mrestart\e[0m'
	echo -e 'Update the Drupal installation: \e[36mmake \e[0m\e[1mupdate\e[0m'
	echo -e 'Clear the app caches: \e[36mmake \e[0m\e[1mcc\e[0m'
	echo -e 'Export the Drupal configs: \e[36mmake \e[0m\e[1mcex\e[0m'
	echo -e 'SSH to the app terminal: \e[36mmake \e[0m\e[1mssh\e[0m'
	echo -e 'Import a database. (Required argument FILE=this/is/the_path_to_my_file.sql): \e[36mmake \e[0m\e[1mimport-db\e[0m'
endef
