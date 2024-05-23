# How to execute a test e2e


```bash
docker run -it --rm \
  -v $(pwd)/cypress:/e2e/cypress \
  -w /e2e \
  cypress/included:latest \
  run
```