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
> Login JSON request body example:
```
{"username":"test","password":"test"}
```
for creating user check [FOSUserBundle](https://symfony.com/doc/2.0/bundles/FOSUserBundle/command_line_tools.html#create-a-user) doc

> Create new team
```
POST /api/team 
```
> Get list of league teams
```
GET /api/team/{leagueId} 
```
> Update team data
```
PUT /api/team/{leagueId} 
```
> Remove league
```
DELETE /api/league/{leagueId} 
```
