# Memo Gram

# Page & Response

```php
class Container
{
    public function myPage()
    {
        return "Hello World!";
    }
}
```

```php
class SomethingElse
{
    public function foo()
    {
        open([Container::class, 'myPage']);
    }
}
```

Message response:

```php
public function myPage()
{
    return messageResponse("Hello world!")
        ->schema([
            [key("Hi")->then(fn() => "Hi too!")]
        ]);
}
```

Glass message response:

```php
public function myPage()
{
    return glassMessageResponse("Hello world!")
        ->schema([
            [glassKey("Hi")->then(fn() => "Hi too!")]
        ]);
}
```

Delete message:

```php
public function myPage()
{
    return deleteResponse('main');
}
```

Listeners:

```php
public function myPage()
{
    onAny()

    return "Something...";
}
```
