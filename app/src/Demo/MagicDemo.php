<?php
/**
 * @author Saqqal Abdelaziz <seqqal.abdelaziz@gmail.com>
 * @Linkedin https://www.linkedin.com/abdelaziz-saqqal
 */

namespace App\Demo;

class MagicDemo
{
    private array $data = [];
    private array $hidden = ['password', 'secret'];

    // Magic method: Called when creating a new instance
    public function __construct(string $message = '')
    {
        echo "__construct: Object is being created! $message\n";
    }

    // Magic method: Called when setting inaccessible/non-existing properties
    public function __set(string $name, mixed $value): void
    {
        echo "__set: Setting '$name' to '$value'\n";
        $this->data[$name] = $value;
    }

    // Magic method: Called when getting inaccessible/non-existing properties
    public function __get(string $name): mixed
    {
        echo "__get: Getting value of '$name'\n";
        return $this->data[$name] ?? null;
    }

    // Magic method: Called when checking if inaccessible/non-existing properties exist
    public function __isset(string $name): bool
    {
        echo "__isset: Checking if '$name' exists\n";
        return isset($this->data[$name]);
    }

    // Magic method: Called when unsetting inaccessible/non-existing properties
    public function __unset(string $name): void
    {
        echo "__unset: Unsetting '$name'\n";
        unset($this->data[$name]);
    }

    // Magic method: Called when trying to call object as a function
    public function __invoke(string $argument): string
    {
        return "__invoke: Object called as function with argument: $argument";
    }

    // Magic method: Called when converting object to string
    public function __toString(): string
    {
        return "__toString: Object contains " . count($this->data) . " items";
    }

    // Magic method: Called when cloning object
    public function __clone(): void
    {
        echo "__clone: Object is being cloned!\n";
        $this->data['cloned_at'] = new \DateTime();
    }

    // Magic method: Called when var_dump() or print_r() is used
    public function __debugInfo(): array
    {
        $debug = $this->data;
        // Hide sensitive information
        foreach ($this->hidden as $key) {
            if (isset($debug[$key])) {
                $debug[$key] = '***hidden***';
            }
        }
        return $debug;
    }

    // Magic method: Called when serializing object
    public function __sleep(): array
    {
        echo "__sleep: Object is being serialized!\n";
        return ['data']; // Only serialize the data property
    }

    // Magic method: Called when unserializing object
    public function __wakeup(): void
    {
        echo "__wakeup: Object is being unserialized!\n";
        $this->hidden = ['password', 'secret']; // Restore hidden properties
    }

    // Magic method: Called when using var_export()
    public static function __set_state(array $array): self
    {
        $obj = new self();
        $obj->data = $array['data'];
        return $obj;
    }
}