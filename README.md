# prometheus-targets-manager

....

## Features

- Document upload
- 


## Deployment



### Docker compose

.....

## Tech Stack

**Server:** Symfony




## Run Locally

Clone the project

```bash
  git clone https://github.com/soflane/prometheus-targets-manager
```

Go to the project directory

```bash
  cd prometheus-targets-manager
  
  cp .env.docker .env
  cp symfony/.env.dist symfony/.env
```

Install dependencies

```bash
  make setup
```

Add the following domains to the hosts file.
/etc/hosts on macOS & linux or "C:\Windows\System32\drivers\etc\hosts" on Windows

```txt
127.0.0.1 ${APP_NAME}.docker.test
127.0.0.1 ${APP_NAME}-db.docker.test
```
Add self-signed SSL certificate to local store on Windows/MacOS
```shell
#MacOS / Linux
sudo security add-trusted-cert -d -r trustRoot -k /Library/Keychains/System.keychain .docker/certs/docker.crt

#Windows in powershell as admin
certutil -addstore -f "ROOT" .docker/certs/docker.crt
```

## Authors

- [@franmako](https://www.github.com/franmako)
- [@soflane](https://github.com/soflane)

