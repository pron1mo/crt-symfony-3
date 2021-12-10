# crt-symfony-3
Small personal blog based on symfony 5.4

---
## How to deploy:
+ clone repository `git clone git@github.com:pron1mo/crt-symfony-3.git`
+ run `docker-compose up -d`
+ open in browser `http://localhost`

p.s.
For demo purpose repository has dump of database with 3 users:
```shell
username  | password
---------------------
admin     | admin     (have full permissions)
moder     | moder     (can't edit/create static pages)
user      | user      (can read articles/static pages and create comments)
```
and 7 articles, 4 tags, 1 static page

---



In some cases you may want to create user with administrator permissions, to do this, run the command:
```bash
docker-compose exec app bin/console app:create-user
```
and follow the instructions
