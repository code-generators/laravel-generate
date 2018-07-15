# Laravel Generate

Generate models and controllers with a Rails-style database field definitions:

```bash
php artisan g:model <name> [field[:type][:index] field[:type][:index]]
```

For example, the following command would create a model and migration:

```
artisan g:model Car make model certified_at:datetime msrp:float
```

The migration would look like:

```php
public function up()
{
    Schema::create('cars', function (Blueprint $table) {
        $table->increments('id');
        $table->string('make');
        $table->string('model');
        $table->dateTime('certified_at');
        $table->float('msrp');
        $table->timestamps();
    });
}
```

