sh:
	docker exec -it teamleader.php bash

up-detached:
	docker-compose up -d

stop:
	docker-compose stop

down: 
	docker-compose down