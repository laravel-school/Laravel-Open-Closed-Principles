# Implement the Open Closed Principle in Laravel for Sign Up

 In this tutorial,  I will show you how to implement the Open Closed Principle in Laravel for Sign up a user. Here my intention is to apply OCP on Sign up so that you can relate it to your real-life scenario. 


## Scenario
Imagine you have a project where you want to allow your user to __sing up__ via __email__. In this scenario, you may think to use a __JoinController__ and a __model__ to write code for sign up. That's fine. 

A few months later, you may decide to allow the user to sign up via __facebook__. In that case, you need to go to the `JoinController` again and then modify your code via `if-else` condition to check what is the user's intention to sign up, then add data into your DB. That's could be fine as well.

Again after few months, you may change your mind to add sign up option via Gmail. Do the same things as the one you did for facebook sign up. 

And again, if you want to add more and more option for sign up, you have to repeat the steps again and again. 

Wait a minute...

Have you notice that every time if we add a new option to sing up, we need to change our entire code, then add `if-else` to catch the appropriate type and so on. Don't you think that you are editing the same code again and again for the same purpose? Wouldn't it better to have a code style for sign up that allows you to create separate files for each signup and that's it? I personally like that structure. 

In this scenario, the concept of the open-closed principle has come-
> Software entities ... should be open for extension, but closed for modification."


## Does OCP fit for this issue?
I strongly believe, the OCP is the right fit to solve this issue. To solve this issue, we need to create the following files-

- JoinController
- Interfaces/JoinInterface
- Repositories/AuthRepository
- Repositories/JoinRepository
- Repositories/JoinByEmail


## Let's Start
First of all, let's define the route in `web.php` file. 

__web.php__
```
<?php
Route::get('/join', 'JoinController@create')->name('join');
Route::post('/join', 'JoinController@store')->name('join');
```

Now, let's create a controller called `JoinController`. Here could be the command line instruction-

```
php artisan make:controller JoinController
```

Then, create a directory __app\Http\Interfaces__ and create a new file on that called __JoinInterface.php__.

The next things is to create a new directory called __app\Http\Repositories__ and create two files called __AuthRepository.php__ and __JoinByEmail.php__. 

Now, let's add code in the `JoinController`. 
```php 
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Repositories\JoinByEmail;
use App\Http\Repositories\JoinRepository;
use App\Http\Repositories\AuthRepository;
use Illuminate\Http\Request;

class JoinController extends Controller
{
    public function store(Request $request)
    {
        // Put form validation

        $authRepository = new JoinRepository(new JoinByEmail());

        $authRepository->store($request);

        return redirect()->route('join')->with('success', 'You have joined successfully.');
    }
}
```

Here, I have instantiated `JoinRepository` and injected `JoinByEmail()`. Then I called a `store()` method from the `JoinRepository` bypassing all the user's form data. 


Next, go to the `JoinRepository`. 

```php 
<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\JoinInterface;
use Illuminate\Http\Request;

class JoinRepository
{
    protected $joinInterface;

    public function __construct(JoinInterface $joinInterface)
    {
        $this->joinInterface = $joinInterface;
    }

    public function store(Request $request)
    {
        $this->joinInterface->store($request);
    }
}
```

Here, I injected `JoinInterface` in the constructor then called `store()` method from the `JoinInterface`. 

Next, move to the `JoinInterface` to declare methods. 

```php 

<?php
namespace App\Http\Interfaces;

use Illuminate\Http\Request;

interface JoinInterface
{
    public function store(Request $request);
}
```

Here, I just define a method called `store()`. Whoever wants to implement the interface, they need to implement `store()` method. 

So far we have done all the settings. Finally, we need to update the `JoinByEmail` class. 

```php
<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\JoinInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JoinByEmail implements JoinInterface
{
    public function store(Request $request)
    {
        $name = $request->first_name . ' ' . $request->last_name;

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'is_public' => 1,
            'usertype' => User::USERTYPE['regular'],
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activate' => User::ACTIVATE['inactive'],
            'flag' => 0,
            'activationcode' => Str::random(32)
        ]);

        // Trigger an email to sign up user

        return $user;
    }
}
```

Here, I have implemented `JoinInterface` in `JoinByEmail`. So, it obvious that we need to have a `store()` method in `JoinByEmail`. Then I put code to store user's data into the `store()` method. 


So far we have done. Now if we run the server and try to access `http://127.0.0.1:8000/join` URL, then we should able to sign up (You have to include the signup form and then connect to the form action to the right place).


## Does this coding style solve our issue?

Well, let's validate our issue. Does it really solve the problem that we have discussed earlier in this article? 

This is our stable code. The code works fine for sign up by email. Now, let's think to add sign-system via facebook. So, in this case, I will just create a new file in the __repositories__ folder called `JoinByFacebook` and then write our facebook sign up code mechanism into the `store()` method. 


```php
<?php
namespace App\Http\Repositories;

use App\Http\Interfaces\JoinInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JoinByFacebook implements JoinInterface
{
    public function store(Request $request)
    {
        // Collect data from user's facebook

        // Store into table

        // Trigger an email to sign up user

        return $user;
    }
}
```

And lastly, in the `store()` method of your controller, update following line and inject `JoinByFacebook()` into the `JoinRepository`. 

```php
	public function store(Request $request)
    {
        // Put form validation

        $authRepository = new JoinRepository(new JoinByFacebook());

        $authRepository->store($request);

        return redirect()->route('join')->with('success', 'You have joined successfully.');
    }
```

That's it. 

You don't have to change any logic there. Just inject different class based on your criteria. 

Isn't that better than user `if-else` and changing code again and again?

[Get all the code in this repo](https://github.com/laravel-school/Laravel-Open-Closed-Principle-for-Sign-Up).

Please share your thought if you think it can be more improved. 


This article has posted to [Laravel School](http://laravel-school.com/posts/implement-the-open-closed-principle-in-laravel-for-sign-up-43) first.


Thank you. 


