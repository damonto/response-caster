# Laravel Response Caster

Require this package with Composer:

```bash
$ composer require damonto/response-caster
```

Then add response caster trait to your base controller.

> app\Http\Controllers\Controller

```
<?php

namespace App\Http\Controllers;

use Damonto\ResponseCaster;
...

class Controller extends Controller
{
    use ResponseCaster;
}
```

Now U can use the response caster in your code.

> Respond with a created response

```php
$this->response()->created(?string $location);
```

> Also supports Laravel JSON resources.

```php
$this->response()->resource(new FakeResource([]));
```

> Response structure:

```JSON
{
    "status": true,
    "status_code": 200,
    "message": null,
    "data": []
}
```
