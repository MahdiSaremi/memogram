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
    onAny(function () {
        return "Hello world";
    });
    onMessage("Bar")->then(function () {
        return "Baz";
    });

    return "Something...";
}
```

Validations:

```php
Validation::make(['update', 'message', 'text', 'max:255'])->validate();
```

## Extra

Trap Join

routes/bot.php:
```php
onCommand('/start {inviter}', function ($inviter) {
    open([StartSection::class, 'start'], ['inviter' => $inviter]);
});
```

StartSection.php:
```php
class StartSection
{
    public function start()
    {
        $inviter = useParam('inviter');
        
        if (mounting()) {
            if ($this->joined()) {
                $this->giveInviteCoin($inviter);
                open([HomeSection::class, 'main']);
                return;
            }
        };
        
        onAny(function () {
            return "You should join the channels first.";
        })->atFirst();
        
        return messageResponse("First join the channels.")
            ->schema([
                [key("Check")->atFirst()->then(function {
                    if ($this->joined()) {
                        $this->giveInviteCoin($inviter);
                        yield "Good job!";
                        open([HomeSection::class, 'main']);
                    } else {
                        yield "You're not joined yet!";
                    }
                })],
            ])
    }
}
```
