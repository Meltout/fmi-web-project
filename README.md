# Build and run Docker container

## 1. Build the Docker image 

```bash
docker build -t my-php-app .
```

Replace my-php-app with your desired image name.

## 2. Run the docker container

```bash
docker run -p 8080:80 my-php-app
```

This assumes your PHP application will run on port 80 inside the container, and it maps the container's port 80 to your host machine's port 8080. Adjust the port mapping as needed.
