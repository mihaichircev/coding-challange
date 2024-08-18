sh:
	docker exec -it teamleader.php bash

build:
	docker-compose build

install: build up-detached

up-detached:
	docker-compose up -d

stop:
	docker-compose stop

down: 
	docker-compose down