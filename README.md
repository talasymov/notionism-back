# Notionism Back End

The best place for notion fans.

## Installation

Before start application, install & run [docker](https://docker.com/).

## Usage

Setup .env file

```bash
cp .env.example .env
```

Fill in the config for google authorization

```dotenv
SOCIALITE_GOOGLE_CLIENT_ID=
SOCIALITE_GOOGLE_CLIENT_SECRET=
```

Launch application

```bash
docker-compose up -d
```

### Install requirements

```bash
docker exec -it notionism-php composer install
```

### Run migrations & seeders

```bash
docker exec -it notionism-php php artisan migrate --seed
```

### Enjoy app

Open [website](http://localhost:8000).

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
