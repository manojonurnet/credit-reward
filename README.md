<p align="center">
    <h1 align="center">Credit Reward System</h1>
    <br>
</p>

This project is built with Yii 2 Basic Project Template.

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------

Clone the project using the following command:

~~~
git clone {git_url}
~~~

After cloning, cd into the project folder and install the dependencies using the following command:

~~~
composer install
~~~

Edit the file `config/db.php` with your database credentials:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=credit_reward',
    'username' => 'root',
    'password' => 'your_mysql_password',
    'charset' => 'utf8',
];
```

Run migrations using the following command:

~~~
php yii migrate
~~~

Seed database using the following command:

~~~
php yii seed
~~~

Start the built-in web server using the following command:

~~~
php yii serve
~~~

Now you should be able to access the application through the following URL.

~~~
http://localhost:8080/
~~~

Reward calculation can be scheduled to work on certain intervals. Reward is calculated using the following command:

~~~
php yii reward
~~~
This command calculates and updates rewards for all customers, as well as checks for expired rewards.

To test, you may add orders, and then run the above command to see the credits updated in customer table.

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
