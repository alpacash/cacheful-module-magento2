# Cacheful Magento 2 Module
**Cacheful** offers a simple, yet powerful way to warm-up your website cache.
This specific module for Magento 2 integrates with the
cacheful API in order to initiate
a warm-up process, either manually or automatically
after your website cache has been flushed. This way the first page load for
every request is handled by the server, so that no actual visitor has to
deal with delay in page load.

## Quick start in 5 steps
- Create a free account [on cacheful](https://cacheful.app).
- Create your first team and project.
- Go to `your settings -> API` and create your first API token.
- Copy your *project ID* and _API token_ here:
    - `system config -> cacheful client -> connection`.
- Enable "Initiate warm-up after cache flush" option here:
    - `system config -> cacheful client -> general`.

## Initiate warm-up manually
Run the following command to initiate a warm-up
using your configured credentials.

`$ bin/magento cacheful:execute`

## Initiate warm-up after cache flush
Enable "Initiate warm-up after cache flush" option
in system configuration, so that the cache warm-up will be triggered after 
each cache flush as long as the project is idle, avoiding concurrent
warm-up processes.

## API endpoints
You can also do API requests manually if you like, for example using Guzzle.

`/api/projects/:key/process`

**Headers**
```json
{
  "Authorization": "Bearer :token",
  "Accept": "application/json"
}
```

## Using Guzzle
```php
    $url = 'https://cacheful.app/api/projects/%s/process';

    $projectId = 'your-project-id';
    $token = 'your-api-token';
    $requestUrl = sprintf($url, $projectId);

    $request = $client->request('POST', $requestUrl, [
        'headers' => [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ]
    ]);

    if ($request->getStatusCode() === '200') {
        // successfully queued
    }
```

**Status codes**
- `200` when the process has been added to the queue successfully.
- `409` if the project status is `running` or `pending`.
