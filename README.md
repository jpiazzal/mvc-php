# mvc-php
A basic PHP Model View Controller to create your own framework or app from scratch.

## Table of Contents

- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Usage

### Front End

If you want to keep Boostrap, a quick start [here](https://getbootstrap.com/docs/4.2/getting-started/introduction/).

To use others frameworks or update the front end, everything you need is in the folder `app/views/`.

Add css and js in the folders `public/css/` and `public/js/`.<br />
`style.css` and `script.js` already exist and are included in `app/views/layout.php`.

### Back End

#### Run the framework

Initialization, autloading and routing are made in `core/Router.php`.

To use it, require the file `Router.php` and run the framework in your `index.php`:

```php
<?php
require "core/Router.php";
Router::run();
```

#### Models

If you want to create a new model add it to the folder `app/models/`.<br />
**/!\ Use the syntax** `XxxModel` **for the name of the file and the class (case sensitive).**<br />
Do not require your file, autoloading do it for you.

All models classes must extends from the class Model in `core/Model.php`.

Example: `app/models/ExampleModel.php`

```php
<?php
// Add namespace to avoid conflicts
namespace App\Models;

// Import Model class namespace
use \Core\Model;

// Extends from the class Model
class ExampleModel extends Model {

}
```

#### Controllers

If you want to create a new controller add it to the folder `app/controllers/home` (depending on what your controller do).<br />
**/!\ Use the syntax** `XxxController` **for the name of the file and the class (case sensitive).**<br />
Do not require your file, autoloading do it for you.

All controllers classes must extends from the class Controller in `core/Controller.php`.

Example: `app/controllers/home/IndexController.php`

```php
<?php
// Add namespace to avoid conflicts
namespace App\Controllers\Home;

// Import Controller class namespace
use \Core\Controller;

// Home controllers Extends from the class Controller
class IndexController extends Controller {

}
```

#### Routing

Routing is made by a query string.

In the example `index.php?p=home&c=index&a=index`, there are 3 parameters:

- `p` define the **Platform** that you want to display, here `home`. It choose the path to the right controller and view.<br />
In the example: `app/controllers/home/` and `app/views/home/`.<br />
Default value: `home`.

- `c` is the **Controller** used.<br />
In the example `index` for `app/controllers/home/IndexController.php`.<br />
Default value: `index`.

- `a` is the **Action** asked to the controller. It choose the right view.<br />
In the example, `index` is a method of `IndexController`.<br />
The name of the view is `index.php` in `app/views/home/index.php`.<br />
Default value: `index`.

### Database

Database calls are made in `core/Mysql.php`.

Database configuration is in `config/config.php`.

Differents uses of `Mysql` instance in a model class, `$this->db` is instantiate in the constructor in `Model` class:

```php
<?php
namespace App\Models;

use \Core\Model;

/**
 * Example model class
 */
class ExampleModel extends Model {

	public function exampleFunction() {
		$result = $db->query("SELECT title from news WHERE id = 1");
		$result = $db->query("SELECT title from news WHERE id = ? AND author_id = ?", array("1", "1"));
		$result = $db->query("SELECT title from news WHERE id = :id", array("id" => "1"));
	}

}
```

`$result`:

```php
Array
(
	[0] => Array
		(
			[title] => "My Title"
		)
)
```

`WHERE IN` is not supported for now.

## License

*mvc-php* is [licensed](https://github.com/jpiazzal/mvc-php/blob/master/LICENSE) under the MIT license.
