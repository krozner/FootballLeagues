### FootballLeague

> Build & run app

```sh
$ docker-compose up -d
```
> App install

```sh
$ bin/app-bash install
```

#### Endpoints

> Login
```
POST /api/login_check 
```
login JSON request body example:
```
{"username":"test","password":"test"}
```
for creating user check [FOSUserBundle](https://symfony.com/doc/2.0/bundles/FOSUserBundle/command_line_tools.html#create-a-user) doc

> Get list of league teams
```
GET /api/team/{leagueId} 
```
> Create new team
```
POST /api/team 
```
> Update team data
```
PUT /api/team/{leagueId} 
```
JSON request body example:
```
{"name": "Some name of football team", "league": 1, "strip": "example text"}
```
* name & league are required fields

> Remove league
```
DELETE /api/league/{leagueId} 
```
