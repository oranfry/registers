# Registers

Simple framework for creating object registers.

Useful of you want to get an object from anywhere, without creating a new instance if one already exists, and without creating an instance unless and until it is needed.

It also introduces an alias layer to referring to classes, meaning you could easily swap implementations by changing one line of code.

## Usage

First implement a register:

```php
use Registers\Register;

Register::register('wozzle', [
    'big' => \Acme\Wozzles\Big::class,
    'small' => \Acme\Wozzles\Small::class,
]);
```

Now you can grab a big or small wozzle from anywhere:

```php
use Registers\Register;

Register::::load('wozzle', 'big');

$wozzle->fizzle();

if (Register::::available('wozzle', 'medium')) {
    Register::::load('wozzle', 'medium')->wiggle();
}

echo "All available wozzles:<br><pre>\n";
var_dump(Register::::available('wozzle'));
echo "</pre>";

```

If this is the first time asking for a big wozzle, a new instance will be created and saved in the register.

Otherwise, the instance already in the register will be returned for your use.
