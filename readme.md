
## Dummy Blog – Getting Started with Sail

### Requirements
* Docker Desktop (🧊 required for Sail)
* Git

###  Installation Steps
1. Clone the Repository

```bash
 git clone https://github.com/GeorgePapanotas1/dummy-blog.git
 cd dummy-blog
```

2. Copy the .env File

```bash
cp .env.example .env 
```

3. Install Dependencies

```bash 
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Then bring up the Sail containers and install dependencies:

```bash 
./vendor/bin/sail up -d
```

4. Generate the Application Key

```bash 
./vendor/bin/sail artisan key:generate 
```


5. Run Install Command

```bash
 ./vendor/bin/sail artisan version:install
```

6. Install NPM dependencies

```bash
 ./vendor/bin/sail npm install
```

7. Build NPM App 

```bash
 ./vendor/bin/sail npm run dev
```

8. Access the Application
   Once the containers are up, open your browser:

```text 
http://localhost 
```

