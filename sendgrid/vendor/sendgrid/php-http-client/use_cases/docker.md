# Docker

You can run the example code at `examples/example.php` in a Docker container.

From the root directory:

```bash
cp examples/.env_sample .env
```

Update the `.env` file with your SendGrid API Key. If you don't have one, you can get one [here](https://sendgrid.com/free?source=php-http-client).

Add the `.env` file to your `.gitignore` file if you are publishing your code publically.

```
source .env
docker build --build-arg sendgrid_apikey=$SENDGRID_API_KEY -t client .
docker run client php examples/example.php
```

You should see a list of your SendGrid API Keys.
