# Build and run Docker container

## 1. Build the Docker image 

```bash
docker build -t my-php-app .
```

Replace my-php-app with your desired image name.

## 2. Run the docker container

```bash
docker run -p 8080:8080 -p 8000:8000 my-php-app
```

